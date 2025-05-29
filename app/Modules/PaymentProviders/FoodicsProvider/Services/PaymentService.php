<?php

namespace App\Modules\PaymentProviders\FoodicsProvider\Services;

use App\Dto\TransactionDto;
use App\Enums\PaymentProviderEnum;
use App\Enums\TransactionTypeEnum;
use App\Modules\PaymentProviders\AbstractPaymentProvider\Jobs\StoreTransactionJob;
use App\Modules\PaymentProviders\AbstractPaymentProvider\Services\AbstractPaymentService;
use App\Repositories\Client\ClientRepository;
use App\Repositories\PaymentProvider\PaymentProviderRepository;
use Carbon\Carbon;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Throwable;

class PaymentService extends AbstractPaymentService
{

    public function __construct(private readonly PaymentProviderRepository $paymentProviderRepository,
                                private readonly ClientRepository $clientRepository)
    {
        parent::__construct();
    }

    /**
     * @throws Throwable
     */
    public function parseWebhook($payload): array
    {
        $transactions = [];
        $oneLinePayload = preg_replace('~\R~', ' ', trim($payload));
        $payloadTransactions = preg_split('/(?=\d{11},\d{2}\#)/', $oneLinePayload, -1, PREG_SPLIT_NO_EMPTY);

        if (!empty($payloadTransactions)) {
            foreach ($payloadTransactions as $payloadTransaction) {
                $line = trim($payloadTransaction);
                // Check transaction string segments count
                $segments = explode('#', $line);
                if (count($segments) != 3) {
                    continue;
                }

                [$dateAndAmount, $reference, $keyValuePairs] = explode('#', $payloadTransaction);
                [$date, $amount] = explode(',', $dateAndAmount);

                if (empty($reference) || empty($amount)) {
                    continue;
                }

                // Resolve Key => value pairs
                $keyValuePairs = explode('/', $keyValuePairs);
                $transactionNotes = [];
                for ($i = 0; $i < count($keyValuePairs) - 1; $i += 2) {
                    $key = trim($keyValuePairs[$i]);
                    $value = trim($keyValuePairs[$i + 1]);

                    $transactionNotes[$key] = $value;
                }
                $client = $this->clientRepository->findWhere(['reference' => $reference])->first();
                if (!$client) {
                    continue;
                }
                $provider = $this->paymentProviderRepository->getProviderByCode(PaymentProviderEnum::FOODICS->value);
                //return Carbon::createFromFormat('Ymd', substr($date, 0, 8))->toDateString();
                $transactions[] = new TransactionDto(
                    reference: $reference,
                    amount: $amount,
                    type: TransactionTypeEnum::CREDIT->value,
                    transaction_date: Carbon::createFromFormat('Ymd', substr($date, 0, 8))->toDateString(),
                    client_id: $client->id,
                    payment_provider_id: $provider->id,
                    notes: $transactionNotes,
                    transaction_object: $payload
                );
            }
        }
        // Save Transactions
        if (!empty($transactions)) {
            $this->dispatchTransactionsBatch($transactions);
        }
        return $transactions;
    }

    /**
     * @throws Throwable
     */
    private function dispatchTransactionsBatch(array $transactions): void
    {
        $jobs = [];

        foreach ($transactions as $transaction) {
            $jobs[] = new StoreTransactionJob($transaction);
        }

        Bus::batch($jobs)
            ->name('Webhook Transactions Batch')
            ->onQueue('transactions')
            ->then(function (Batch $batch) {
                Log::info("Batch #{$batch->id} completed successfully.");
            })
            ->catch(function (Batch $batch, Throwable $e) {
                Log::error("Batch #{$batch->id} failed.", [
                    'error' => $e->getMessage()
                ]);
            })
            ->finally(function (Batch $batch) {
                Log::info("Batch #{$batch->id} finished (success or fail).");
            })
            ->dispatch();
    }

    public function supportsIncoming(): bool
    {
        return true;
    }

    public function supportsOutgoing(): bool
    {
        return true;
    }
}
