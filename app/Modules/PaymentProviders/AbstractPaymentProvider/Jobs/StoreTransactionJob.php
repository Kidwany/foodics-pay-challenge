<?php

namespace App\Modules\PaymentProviders\AbstractPaymentProvider\Jobs;

use App\Dto\TransactionDto;
use App\Services\Transaction\TransactionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class StoreTransactionJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly TransactionDto $transactionDto)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(TransactionService $transactionService): void
    {
        $transactionService->storeFromDto($this->transactionDto);
    }
}
