<?php

namespace App\Livewire\Forms;

use Carbon\Carbon;
use App\Helper\Files;
use Razorpay\Api\Api;
use App\Models\Payment;
use App\Models\Society;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\StripePayment;
use Illuminate\Support\Facades\Http;
use App\Models\RazorpayPayment;
use App\Models\MaintenanceApartment;
use App\Models\AdminFlutterwavePayment;
use App\Models\PaymentGatewayCredential;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class MaintenancePay extends Component
{
    use WithFileUploads, LivewireAlert;

    public $file;
    public $fileUrl;
    public $paymentProof;
    public $apartment_maintenance;
    public $paid_status;
    public $paymentDate;
    public $billDate;
    public $showPayUtilityBillModal = false;
    public $id;
    public $society;
    public $paymentGateway;
    public $paymentOrder;
    public $razorpayStatus;
    public $stripeStatus;
    public $showPaymentDetail = false;
    public $amount;
    public $paymentMethod = 'offline';

    public function mount()
    {
        $this->paid_status = $this->apartment_maintenance->paid_status;
        $this->amount = $this->apartment_maintenance->cost;
        $this->paymentProof = $this->apartment_maintenance->payment_proof;
        $this->paymentDate = now()->format('Y-m-d');
        $this->paymentGateway = PaymentGatewayCredential::withoutGlobalScopes()->where('society_id', society()->id)->first();
        $this->paymentOrder = null;
        $this->society = $this->getSociety();
    }

    private function getSociety()
    {
        return Society::where('id', society()->id)->first();
    }

    public function submitForm()
    {
        $rules = [
            'paymentDate' => 'required',
        ];

        $this->validate($rules);
        $this->paymentDate = Carbon::parse($this->paymentDate)->format('Y-m-d');
        $this->apartment_maintenance->payment_date = $this->paymentDate;

        if ($this->paymentProof) {
            $filename = Files::uploadLocalOrS3($this->paymentProof, '/');
            $this->paymentProof = $filename;
            $this->apartment_maintenance->payment_proof = $this->paymentProof;
        }

        $this->apartment_maintenance->paid_status    = "paid";

        $this->apartment_maintenance->save();

        $this->alert('success', __('messages.maintenancePaid'));

        $this->dispatch('hidePay');
    }


    #[On('resetFileData')]
    public function resetFileData()
    {

        $this->paymentProof = '';
        $this->resetValidation();
    }

    public function initiateStripePayment($id)
    {


        $payment = StripePayment::create([
            'maintenance_apartment_id' => $id,
            'amount' => $this->amount
        ]);

        $this->dispatch('stripePaymentInitiated', payment: $payment);
    }

    public function initiatePayment($id)
    {
        $payment = RazorpayPayment::create([
            'maintenance_apartment_id' => $id,
            'amount' => $this->amount
        ]);

        $orderData = [
            'amount' => ($this->amount * 100),
            'currency' => $this->society->currency->currency_code
        ];

        $apiKey = $this->society->paymentGateways->razorpay_key;
        $secretKey = $this->society->paymentGateways->razorpay_secret;

        $api  = new Api($apiKey, $secretKey);
        $razorpayOrder = $api->order->create($orderData);
        $payment->razorpay_order_id = $razorpayOrder->id;
        $payment->save();

        $this->dispatch('paymentInitiated', payment: $payment);
    }

    #[On('razorpayPaymentCompleted')]
    public function razorpayPaymentCompleted($razorpayPaymentID, $razorpayOrderID, $razorpaySignature)
    {
        $payment = RazorpayPayment::where('razorpay_order_id', $razorpayOrderID)
            ->where('payment_status', 'pending')
            ->first();

        if ($payment) {
            $payment->razorpay_payment_id = $razorpayPaymentID;
            $payment->payment_status = 'completed';
            $payment->payment_date = now()->toDateTimeString();
            $payment->razorpay_signature = $razorpaySignature;
            $payment->save();

            $order = MaintenanceApartment::find($payment->maintenance_apartment_id);
            $order->cost = $payment->amount;
            $order->payment_date = $payment->payment_date;
            $order->paid_status = 'paid';
            $order->save();

            Payment::create([
                'maintenance_apartment_id' => $payment->maintenance_apartment_id,
                'payment_method' => 'razorpay',
                'amount' => $payment->amount,
                'transaction_id' => $razorpayPaymentID
            ]);

            $this->alert('success', __('messages.maintenancePaid'), [
                'toast' => false,
                'position' => 'center',
                'showCancelButton' => true,
                'cancelButtonText' => __('app.close')
            ]);


            return redirect()->route('maintenance.index');
        }

    }


    public function initiateFlutterwavePayment($id)
    {

        try {
            $paymentGateway = $this->society->paymentGateways;
            $apiKey = $paymentGateway->test_flutterwave_key;
            $apiSecret = $paymentGateway->test_flutterwave_secret;
            $apiEncryption = $paymentGateway->test_flutterwave_encryption;


            $user = auth()->user();
            $amount = $this->amount;

            $tx_ref = "txn_" . time();

            $data = [
                "tx_ref" => $tx_ref,
                "amount" => $amount,
                "currency" => $this->society->currency->currency_code,
                "redirect_url" => route('flutterwave.success'),
                "customer" => [
                    "email" => $user->email,
                    "name" => $user->name,
                    "phone_number" => $user->phone,
                ],


                "payment_options" => "card",
            ];
            $response = Http::withHeaders([
                "Authorization" => "Bearer $apiSecret",
                "Content-Type" => "application/json"
            ])->post("https://api.flutterwave.com/v3/payments", $data);

            $responseData = $response->json();

            if (isset($responseData['status']) && $responseData['status'] === 'success') {
                AdminFlutterwavePayment::create([
                    'maintenance_apartment_id' => $id,
                    'flutterwave_payment_id' => $tx_ref,
                    'amount' => $amount,
                    'payment_status' => 'pending',
                ]);

                return redirect($responseData['data']['link']);
            } else {
                return redirect()->route('flutterwave.failed')->withErrors(['error' => 'Payment initiation failed', 'message' => $responseData]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function removeProfilePhoto()
    {
        $this->paymentProof = null;
        $this->dispatch('photo-removed');
    }

    public function togglePaymenntDetail()
    {
        $this->showPaymentDetail = !$this->showPaymentDetail;
    }

    public function render()
    {
        return view('livewire.forms.maintenance-pay');
    }
}
