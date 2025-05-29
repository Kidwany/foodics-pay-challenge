<?php

namespace App\Enums;

enum PaymentProviderEnum: string
{
    case FOODICS = 'foodics';
    case ACME_BANK = 'acme';
}
