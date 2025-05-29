<?php

namespace App\Modules\PaymentProviders\FoodicsProvider\Controllers;

use App\Enums\PaymentProviderEnum;
use App\Modules\PaymentProviders\AbstractPaymentProvider\Controllers\AbstractWebhookController;
use App\Modules\PaymentProviders\AbstractPaymentProvider\Factories\PaymentProviderFactory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends AbstractWebhookController
{

    /**
     * @throws Exception
     */
    public function handle(Request $request)
    {
        try {
            $payload = $request->getContent();
            // Log Webhook
            $provider = PaymentProviderEnum::FOODICS->value;
            Log::info("Webhook Received from $provider with body $payload"); // Also we can log with any driver
            $object = PaymentProviderFactory::make(PaymentProviderEnum::FOODICS->value);
            $object->parseWebhook($payload);
            return response()->json('OK');
        } catch (Exception $exception) {
            Log::error("Error on handling webhook $exception");
            return response()->json('Error on handling webhook');
        }
    }
}
