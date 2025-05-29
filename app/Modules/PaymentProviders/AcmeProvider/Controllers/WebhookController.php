<?php

namespace App\Modules\PaymentProviders\AcmeProvider\Controllers;

use App\Enums\PaymentProviderEnum;
use App\Http\Controllers\Controller;
use App\Modules\PaymentProviders\AbstractPaymentProvider\Controllers\AbstractWebhookController;
use App\Modules\PaymentProviders\AbstractPaymentProvider\Factories\PaymentProviderFactory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends AbstractWebhookController
{
    public function handle(Request $request)
    {
        try {
            $payload = $request->getContent();
            // Log Webhook
            $provider = PaymentProviderEnum::ACME_BANK->value;
            Log::info("Webhook Received from $provider with body $payload"); // Also we can log with any driver
            $object = PaymentProviderFactory::make(PaymentProviderEnum::ACME_BANK->value);
            $object->parseWebhook($payload);
            return response()->json('OK');
        } catch (Exception $exception) {
            Log::error("Error on handling webhook $exception");
            return response()->json('Error on handling webhook');
        }
    }
}
