<?php

namespace App\Modules\PaymentProviders\AbstractPaymentProvider\Jobs;

use App\Dto\TransactionDto;
use App\Services\Transaction\TransactionService;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreTransactionJob implements ShouldQueue
{
    use Queueable, Batchable, InteractsWithQueue, Queueable, SerializesModels ;

    public int $tries = 3;
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
