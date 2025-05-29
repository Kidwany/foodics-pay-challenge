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

class PaymentService extends AbstractPaymentService
{

    public function __construct(private readonly PaymentProviderRepository $paymentProviderRepository,
                                private readonly ClientRepository $clientRepository)
    {
        parent::__construct();
    }

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
            foreach ($transactions as $transaction) {
                dispatch(new StoreTransactionJob($transaction));
            }
        }
        return $transactions;
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
