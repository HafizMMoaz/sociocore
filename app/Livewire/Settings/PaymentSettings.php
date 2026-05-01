<?php

namespace App\Livewire\Settings;

use App\Models\PaymentGatewayCredential;
use Illuminate\Support\Facades\Http;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Helper\Files;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use PhpParser\Node\Expr\Cast\Bool_;

class PaymentSettings extends Component
{

    use LivewireAlert, WithFileUploads;

    public $razorpaySecret;
    public $razorpayKey;
    public $razorpayWebhookKey;
    public $razorpayStatus;
    public $isRazorpayEnabled;
    public $isStripeEnabled;
    public $offlinePaymentMethod;
    public $paymentGateway;
    public $stripeSecret;
    public $activePaymentSetting = 'razorpay';
    public $stripeKey;
    public $stripeWebhookKey;
    public bool $stripeStatus;
    public $enableCashPayment = false;
    public $enableQrPayment = false;
    public $paymentDetails;
    public $qrCodeImage;
    public $isofflinepaymentEnabled;
    public bool $enablePayViaCash;
    public $webhookUrl;
    public $flutterwaveMode;
    public $flutterwaveStatus;
    public $liveFlutterwaveKey;
    public $liveFlutterwaveSecret;
    public $liveFlutterwaveHash;
    public $testFlutterwaveKey;
    public $testFlutterwaveSecret;
    public $testFlutterwaveHash;
    public $flutterwaveWebhookSecretHash;
    public $isFlutterwaveEnabled;

    public function mount()
    {
        $this->paymentGateway = PaymentGatewayCredential::first();
        $acceptMaintenancePayment = in_array('Accept Maintenance Payment', society_modules());

        if (!$acceptMaintenancePayment) {
            $this->enablePayViaCash = true;
            $this->activePaymentSetting = 'offline';
            if ($this->paymentGateway) {
                $this->paymentGateway->update(['is_cash_payment_enabled' => true]);
            }
        }
        $this->setCredentials();
    }

    public function activeSetting($tab)
    {
        $this->activePaymentSetting = $tab;
        $this->setCredentials();
    }

    private function setCredentials()
    {
        $acceptMaintenancePayment = in_array('Accept Maintenance Payment', society_modules());

        if (!$acceptMaintenancePayment) {

            $this->enablePayViaCash = true;
            $this->activePaymentSetting = 'offline';
        } else {
            $this->razorpayKey = $this->paymentGateway->razorpay_key;
            $this->razorpaySecret = $this->paymentGateway->razorpay_secret;
            $this->razorpayWebhookKey = $this->paymentGateway->razorpay_webhook_key;
            $this->razorpayStatus = (bool)$this->paymentGateway->razorpay_status;

            $this->stripeKey = $this->paymentGateway->stripe_key;
            $this->stripeSecret = $this->paymentGateway->stripe_secret;
            $this->stripeWebhookKey = $this->paymentGateway->stripe_webhook_key;
            $this->stripeStatus = (bool)$this->paymentGateway->stripe_status;

            $this->isRazorpayEnabled = $this->paymentGateway->razorpay_status;
            $this->isStripeEnabled = $this->paymentGateway->stripe_status;

            $this->flutterwaveMode = $this->paymentGateway->flutterwave_mode;
            $this->flutterwaveStatus = (bool)$this->paymentGateway->flutterwave_status;
            $this->liveFlutterwaveKey = $this->paymentGateway->live_flutterwave_key;
            $this->liveFlutterwaveSecret = $this->paymentGateway->live_flutterwave_secret;
            $this->liveFlutterwaveHash = $this->paymentGateway->live_flutterwave_hash;
            $this->testFlutterwaveKey = $this->paymentGateway->test_flutterwave_key;
            $this->testFlutterwaveSecret = $this->paymentGateway->test_flutterwave_secret;
            $this->testFlutterwaveHash = $this->paymentGateway->test_flutterwave_hash;
            $this->isFlutterwaveEnabled = $this->paymentGateway->flutterwave_status;
            $this->flutterwaveWebhookSecretHash = $this->paymentGateway->flutterwave_webhook_secret_hash;

            $this->enablePayViaCash = (bool)$this->paymentGateway->is_cash_payment_enabled;
            if (!$this->razorpayStatus && !$this->stripeStatus && !$this->flutterwaveStatus) {
                $this->enablePayViaCash = true;
            }
        }

        
        if ($this->activePaymentSetting === 'stripe') {
            $hash = society()->hash;
            $this->webhookUrl = route('stripe.webhook', ['hash' => $hash]);
        }
        if ($this->activePaymentSetting === 'razorpay') {
            $hash = society()->hash;
            $this->webhookUrl = route('razorpay.webhook', ['hash' => $hash]);
        }
        if ($this->activePaymentSetting === 'flutterwave') {
            $hash = society()->hash;
            $this->webhookUrl = route('flutterwave.webhook', ['hash' => $hash]);
        }
    }

    public function submitFormRazorpay()
    {
        $this->validate([
            'razorpaySecret' => 'required_if:razorpayStatus,true',
            'razorpayKey' => 'required_if:razorpayStatus,true',
        ]);

        if ($this->saveRazorpaySettings() === 0) {
            $this->updatePaymentStatus();
            $this->alertSuccess();
        }

        if (!$this->razorpayStatus && !$this->stripeStatus  && !$this->flutterwaveStatus) {
            $this->enablePayViaCash = true;
        }
    }

    public function submitFormStripe()
    {
        $this->validate([
            'stripeSecret' => 'required_if:stripeStatus,true',
            'stripeKey' => 'required_if:stripeStatus,true',
        ]);

        if ($this->saveStripeSettings() === 0) {
            $this->updatePaymentStatus();
            $this->alertSuccess();
        }

        if (!$this->razorpayStatus && !$this->stripeStatus  && !$this->flutterwaveStatus) {
            $this->enablePayViaCash = true;
        }
    }

    public function submitFormOffline()
    {
        $rules = [
            'enablePayViaCash' => 'required|boolean'
        ];

        $this->validate($rules);

        $updateData = [
            'is_cash_payment_enabled' => $this->enablePayViaCash,

        ];

        $this->paymentGateway->update($updateData);

        $this->updatePaymentStatus();
        $this->alertSuccess();
        if (!$this->razorpayStatus && !$this->stripeStatus  && !$this->flutterwaveStatus) {
            $this->enablePayViaCash = true;
        }
    }

    private function saveRazorpaySettings()
    {
        if (!$this->razorpayStatus) {
            $this->paymentGateway->update([
                'razorpay_status' => $this->razorpayStatus,
            ]);
            return 0;
        }

        try {
            $response = Http::withBasicAuth($this->razorpayKey, $this->razorpaySecret)
                ->get('https://api.razorpay.com/v1/contacts');

            if ($response->successful()) {
                $this->paymentGateway->update([
                    'razorpay_key' => $this->razorpayKey,
                    'razorpay_secret' => $this->razorpaySecret,
                    'razorpay_webhook_key' => $this->razorpayWebhookKey,
                    'razorpay_status' => $this->razorpayStatus,
                ]);
                return 0;
            }

            $this->addError('razorpayKey', 'Invalid Razorpay key or secret.');
        } catch (\Exception $e) {
            $this->addError('razorpayKey', 'Error: ' . $e->getMessage());
        }

        return 1;
    }

    public function submitFormFlutterWave()
    {

        $this->validate([
            'flutterwaveStatus' => 'required|boolean',
            'flutterwaveMode' => 'required_if:flutterwaveStatus,true',
            'liveFlutterwaveKey' => 'required_if:flutterwaveMode,live',
            'liveFlutterwaveSecret' => 'required_if:flutterwaveMode,live',
            'liveFlutterwaveHash' => 'required_if:flutterwaveMode,live',
            'testFlutterwaveKey' => 'required_if:flutterwaveMode,sandbox',
            'testFlutterwaveSecret' => 'required_if:flutterwaveMode,sandbox',
            'testFlutterwaveHash' => 'required_if:flutterwaveMode,sandbox',
            
        ]);

        if ($this->saveFlutterwaveSettings() === 0) {
            $this->updatePaymentStatus();
            $this->alertSuccess();
        }

        if (!$this->razorpayStatus && !$this->stripeStatus  && !$this->flutterwaveStatus) {
            $this->enablePayViaCash = true;
        }
    }

    private function saveFlutterwaveSettings()
    {
        if (!$this->flutterwaveStatus) {
            $this->paymentGateway->update([
                'flutterwave_status' => $this->flutterwaveStatus,

            ]);

            return 0;
        }

        try {
            $apiKey = $this->flutterwaveMode === 'live' ? $this->liveFlutterwaveKey : $this->testFlutterwaveKey;
            $apiSecret = $this->flutterwaveMode === 'live' ? $this->liveFlutterwaveSecret : $this->testFlutterwaveSecret;

            $response = Http::withToken($apiSecret)
            ->get('https://api.flutterwave.com/v3/transactions');

            if ($response->successful()) {
                $this->paymentGateway->update([
                    'flutterwave_mode' => $this->flutterwaveMode,
                    'flutterwave_status' => $this->flutterwaveStatus,
                    'live_flutterwave_key' => $this->liveFlutterwaveKey,
                    'live_flutterwave_secret' => $this->liveFlutterwaveSecret,
                    'live_flutterwave_hash' => $this->liveFlutterwaveHash,
                    'test_flutterwave_key' => $this->testFlutterwaveKey,
                    'test_flutterwave_secret' => $this->testFlutterwaveSecret,
                    'test_flutterwave_hash' => $this->testFlutterwaveHash,
                    'flutterwave_webhook_secret_hash' => $this->flutterwaveWebhookSecretHash,
                ]);

                return 0;
            }
            $this->addError('flutterwaveKey', 'Invalid Flutterwave key or secret.');
        } catch (\Exception $e) {
            $this->addError('flutterwaveKey', 'Error: ' . $e->getMessage());
        }

        return 1;
    }

    private function saveStripeSettings()
    {

        if (!$this->stripeStatus) {
            $this->paymentGateway->update([
                'stripe_status' => $this->stripeStatus,
            ]);
            return 0;
        }

        try {
            $response = Http::withToken($this->stripeSecret)
                ->get('https://api.stripe.com/v1/customers');

            if ($response->successful()) {
                $this->paymentGateway->update([
                    'stripe_key' => $this->stripeKey,
                    'stripe_secret' => $this->stripeSecret,
                    'stripe_webhook_key' => $this->stripeWebhookKey,
                    'stripe_status' => $this->stripeStatus,
                ]);
                return 0;
            }

            $this->addError('stripeKey', 'Invalid Stripe key or secret.');
        } catch (\Exception $e) {
            $this->addError('stripeKey', 'Error: ' . $e->getMessage());
        }

        return 1;
    }

    public function updatePaymentStatus()
    {
        if (!$this->razorpayStatus && !$this->stripeStatus && !$this->flutterwaveStatus) {
            $this->enablePayViaCash = true;
        }

        if ($this->razorpayStatus || $this->stripeStatus || $this->flutterwaveStatus) {
            $this->enablePayViaCash = $this->enablePayViaCash;
        } else {
            $this->enablePayViaCash = true;
        }

        // Save updates in the database
        $this->paymentGateway->update([
            'razorpay_status' => $this->razorpayStatus,
            'stripe_status' => $this->stripeStatus,
            'flutterwave_status' => $this->flutterwaveStatus,
            'is_cash_payment_enabled' => $this->enablePayViaCash,
        ]);

        $this->setCredentials();
        $this->dispatch('settingsUpdated');
        session()->forget('paymentGateway');
    }

    public function alertSuccess()
    {
        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close'),
        ]);
    }

    public function render()
    {
        return view('livewire.settings.payment-settings');
    }
}
