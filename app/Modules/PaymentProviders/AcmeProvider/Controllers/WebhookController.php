<?php

namespace App\Modules\PaymentProviders\AcmeProvider\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\PaymentProviders\AbstractPaymentProvider\Controllers\AbstractWebhookController;
use Illuminate\Http\Request;

class WebhookController extends AbstractWebhookController
{
    public function handle(Request $request)
    {

    }
}
