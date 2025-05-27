<?php

namespace App\Modules\PaymentProviders\AbstractPaymentProvider\Services;

abstract class AbstractPaymentService
{
    abstract public function parseWebhook($payload);
}
