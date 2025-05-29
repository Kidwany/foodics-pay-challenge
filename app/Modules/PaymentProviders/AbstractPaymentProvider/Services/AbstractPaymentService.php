<?php

namespace App\Modules\PaymentProviders\AbstractPaymentProvider\Services;

abstract class AbstractPaymentService
{
    public function __construct()
    {

    }
    abstract public function parseWebhook($payload);
    abstract public function supportsIncoming(): bool;
    abstract public function supportsOutgoing(): bool;
}
