<?php

namespace App\Modules\PaymentProviders\AbstractPaymentProvider\Factories;


use App\Enums\PaymentProviderEnum;

class PaymentProviderFactory
{
    public static function make(string $provider)
    {
        return match ($provider) {
            PaymentProviderEnum::FOODICS->value => app(\App\Modules\PaymentProviders\FoodicsProvider\Services\PaymentService::class),
            PaymentProviderEnum::ACME_BANK->value => app(\App\Modules\PaymentProviders\AcmeProvider\Services\PaymentService::class),
            default => throw new \Exception("Invalid Provider $provider")
        };
    }
}
