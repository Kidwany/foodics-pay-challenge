<?php

namespace App\Modules\PaymentProviders\AbstractPaymentProvider\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class AbstractWebhookController extends Controller
{
    abstract public function handle(Request $request);
}
