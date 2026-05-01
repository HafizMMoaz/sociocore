<?php

namespace App\Livewire\Settings;

use App\Enums\PackageType;
use App\Models\GlobalInvoice;
use App\Models\GlobalSubscription;
use App\Models\OfflinePlanChange;
use App\Models\Package;
use App\Models\Society;
use App\Models\SuperadminPaymentGateway;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

class BillingSettings extends Component
{
    use WithPagination, LivewireAlert;

    public $currentTab;
    public $activeSetting;
    public $currentPackageName;
    public $currentPackageType;
    public $licenseExpireOn;
    public $currentPackageFeatures = [];
    public $nextPaymentDate;
    public function mount()
    {
        $this->showTab('planDetails');
        $society = Society::where('id', society()->id)->first();
        $this->currentPackageName = $society->package->package_name;
        $this->currentPackageFeatures = json_decode($society->package->additional_features, true) ?: [];
        $this->currentPackageType = ucfirst($society->package->package_type->value);
        $this->licenseExpireOn = $society->package->package_type->value !== 'lifetime'
        ? optional($society->license_expire_on)->format('d F, Y')
            : __('modules.package.lifetime');

        $this->nextPaymentDate = GlobalInvoice::where('society_id', $society->id)
            ->where('status', 'active')
            ->whereNotNull('next_pay_date')
            ->orderByDesc('id')
            ->value('next_pay_date');

            $this->nextPaymentDate = optional($this->nextPaymentDate)->format('d F, Y');

        if ($society->package_type) {
            $this->currentPackageType .= ' (' . ucfirst($society->package_type) . ')';
        }

    }

    public function showTab($tab)
    {
        $this->currentTab = $tab;
        $this->activeSetting = $this->currentTab;
    }

    public function downloadReceipt($id)
    {
        $invoice = GlobalInvoice::findOrFail($id);

        if (!$invoice) {

            $this->alert('error', __('messages.noInvoiceFound'), [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close')
            ]);

            return;
        }


        $pdf = Pdf::loadView('billing.billing-receipt', ['invoice' => $invoice]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'billing-receipt-' . uniqid() . '.pdf');
    }

    public function cancelSubscription($cancelType = false)
    {
        $subscription = GlobalSubscription::where('society_id', society()->id)
            ->where('subscription_status', 'active')
            ->latest()
            ->first();

        $subscriptionId = $subscription->subscription_id;
        $gatewayName = $subscription->gateway_name;

        if (!$subscriptionId) {
            $this->alert('error', __('messages.noSubscriptionFound'), [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close')
            ]);
            return;
        }

        $paymentGateway = SuperadminPaymentGateway::first();

        if ($paymentGateway) {
            try {
                if ($gatewayName === 'stripe') {
                    $this->cancelStripeSubscription($subscriptionId, $cancelType, $paymentGateway->stripe_secret);
                } elseif ($gatewayName === 'razorpay') {
                    $this->cancelRazorpaySubscription($subscriptionId, $cancelType, $paymentGateway->razorpay_key, $paymentGateway->razorpay_secret);
                }
                elseif ($gatewayName === 'flutterwave') {
                    $this->cancelFlutterwaveSubscription($subscriptionId, $cancelType, $paymentGateway->flutterwave_secret);
                }
            } catch (\Exception $e) {
                session()->flash('error', $gatewayName . ' Error: ' . $e->getMessage());
            }
        }
    }

    private function cancelStripeSubscription($subscriptionId, $cancelType, $stripeSecret)
    {
        $stripe = new \Stripe\StripeClient($stripeSecret);
        $society = Society::where('id', society()->id)->first();
        if ($cancelType) {
            $stripe->subscriptions->cancel($subscriptionId);
            $this->updateSubscription($society);
        } else {
            $stripe->subscriptions->update($subscriptionId, [
                'cancel_at_period_end' => true,
            ]);

            $society->license_expire_on = \Carbon\Carbon::createFromTimestamp($stripe->subscriptions->retrieve($subscriptionId)->current_period_end)->format('Y-m-d');
            $society->save();
        }

        $this->alert('success', __('messages.subscriptionCancelled'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

        $this->js("Livewire.navigate(window.location.href)");
    }

    private function cancelRazorpaySubscription($subscriptionId, $cancelType, $razorpayKey, $razorpaySecret)
    {
        $api = new \Razorpay\Api\Api($razorpayKey, $razorpaySecret);

        $subscription = $api->subscription->fetch($subscriptionId);

        $subscription->cancel([
            'cancel_at_cycle_end' => $cancelType ? 0 : 1
        ]);

        $society = Society::where('id', society()->id)->first();

        if ($cancelType) {
            $this->updateSubscription($society);
        } else {
            $society->license_expire_on = \Carbon\Carbon::createFromTimestamp($subscription->current_end)->format('Y-m-d');
            $society->save();
        }

        $this->alert('success', __('messages.subscriptionCancelled'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

        $this->js("Livewire.navigate(window.location.href)");
    }

    private function cancelFlutterwaveSubscription($subscriptionId, $cancelType, $flutterwaveSecret)
    {
        $society = Society::where('id', society()->id)->first();

        $url = "https://api.flutterwave.com/v3/subscriptions/{$subscriptionId}/cancel";
        
        $headers = [
            'Authorization: Bearer ' . $flutterwaveSecret,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($cancelType) {
            $this->updateSubscription($society);
        } else {
            $society->license_expire_on = now(); // Immediately expire if not at cycle end
            $society->save();
        }

        $this->alert('success', __('messages.subscriptionCancelled'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

        $this->js("Livewire.navigate(window.location.href)");
       
    }
    public function updateSubscription(Society $society)
    {
        $package = Package::where('package_type', PackageType::DEFAULT)->first();

        $currencyId = $package->currency_id ?: global_setting()->currency_id;


        $expireDate = now()->addMonth();

        $society->package_id = $package->id;
        $society->package_type = 'monthly';
        $society->license_expire_on = $expireDate;
        $society->status = 'active';
        $society->save();

        GlobalSubscription::where('society_id', $society->id)
            ->where('subscription_status', 'active')
            ->update(['subscription_status' => 'inactive']);

        $subscription = new GlobalSubscription();
        $subscription->society_id = $society->id;
        $subscription->package_id = $society->package_id;
        $subscription->currency_id = $currencyId;
        $subscription->package_type = $society->package_type;
        $subscription->quantity = 1;
        $subscription->gateway_name = 'offline';
        $subscription->subscription_status = 'active';
        $subscription->subscribed_on_date = now();
        $subscription->ends_at = $society->license_expire_on;
        $subscription->transaction_id = str(str()->random(15))->upper();
        $subscription->save();

        $offlineInvoice = new GlobalInvoice();
        $offlineInvoice->global_subscription_id = $subscription->id;
        $offlineInvoice->society_id = $subscription->society_id;
        $offlineInvoice->currency_id = $subscription->currency_id;
        $offlineInvoice->package_id = $subscription->package_id;
        $offlineInvoice->package_type = $subscription->package_type;
        $offlineInvoice->total = 0.00;
        $offlineInvoice->pay_date = now();
        $offlineInvoice->next_pay_date = $subscription->ends_at;
        $offlineInvoice->gateway_name = 'offline';
        $offlineInvoice->transaction_id = $subscription->transaction_id;
        $offlineInvoice->save();

    }

    public function render()
    {
        $invoices = GlobalInvoice::where('society_id', society()->id)
            ->orderByDesc('id')
            ->paginate(10);

        $offlinePaymentRequest = OfflinePlanChange::where('society_id', society()->id)->paginate(10);

        return view('livewire.settings.billing-settings', [
            'offlinePaymentRequest' => $offlinePaymentRequest,
            'invoices' => $invoices
        ]);
    }
}
