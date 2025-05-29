<?php

namespace App\Interfaces\Transaction;

use App\Dto\TransactionDto;

interface TransactionServiceInterface
{
    public function storeFromDto(TransactionDto $transactionDto);
}
