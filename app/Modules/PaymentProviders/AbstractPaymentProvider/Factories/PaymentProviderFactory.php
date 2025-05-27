<?php

namespace App\Modules\PaymentProviders\AbstractPaymentProvider\Factories;


class PaymentProviderFactory
{
    public static function make(string $provider)
    {
        return match ($provider) {
            'foodics' => app(\App\Modules\PaymentProviders\FoodicsProvider\Services\PaymentService::class),
            'acme' => app(\App\Modules\PaymentProviders\Acme\Services\PaymentService::class),
            default => throw new \Exception("Invalid Provider $provider")
        };
    }
}
