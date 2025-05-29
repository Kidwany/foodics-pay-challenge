<?php

namespace App\Dto;

readonly class TransactionDto
{
    public function __construct(
        public string  $reference,
        public float   $amount,
        public string  $type,
        public string  $transaction_date,
        public string  $client_id,
        public int     $payment_provider_id,
        public ?string $transaction_code = null,
        public ?string $track_id = null,
        public ?string $currency = 'SAR',
        public ?array $notes = null,
        public ?string  $transaction_object = null,
    ) {}
}
