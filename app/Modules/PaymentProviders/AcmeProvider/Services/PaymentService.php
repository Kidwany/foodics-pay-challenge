<?php

namespace App\Modules\PaymentProviders\AcmeProvider\Services;

use App\Modules\PaymentProviders\AbstractPaymentProvider\Services\AbstractPaymentService;

class PaymentService extends AbstractPaymentService
{

    public function parseWebhook($payload)
    {
        // TODO: Implement parseWebhook() method.
        // The sam concept which used in Foodics bank
    }

    public function supportsIncoming(): bool
    {
        return true;
    }

    public function supportsOutgoing(): bool
    {
        return false;
    }
}
