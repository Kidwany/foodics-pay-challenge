<?php

namespace App\Modules\PaymentProviders\AbstractPaymentProvider\Parsers;

interface WebhookParserInterface
{
    public function parse($payload);
}
