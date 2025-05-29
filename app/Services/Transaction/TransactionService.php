<?php

namespace App\Services\Transaction;

use App\Dto\TransactionDto;
use App\Enums\TransactionTypeEnum;
use App\Interfaces\Transaction\TransactionServiceInterface;
use App\Models\Client;
use App\Repositories\Transaction\TransactionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TransactionService implements TransactionServiceInterface
{
    public function __construct(private readonly TransactionRepository $transactionRepository)
    {

    }
    public function storeFromDto(TransactionDto $transactionDto)
    {
        try {
            DB::beginTransaction();

            $transaction = $this->transactionRepository->findWhere(['reference' => $transactionDto->reference])->first();
            if ($transaction) {
                throw new \Exception('Duplicated Transaction');
            }

            $client = Client::query()->where('id', '=', $transactionDto->client_id)->lockForUpdate()->first();

            $balanceBefore = $client->balance;

            $balanceAfter = match ($transactionDto->type) {
                TransactionTypeEnum::CREDIT->value => $balanceBefore + $transactionDto->amount,
                TransactionTypeEnum::DEBIT->value  => $balanceBefore - $transactionDto->amount,
            };

            $client->update(['balance' => $balanceAfter]);

            $this->transactionRepository->create([
                'transaction_id'       => Str::uuid(),
                'reference'            => $transactionDto->reference,
                'amount'               => $transactionDto->amount,
                'transaction_date'     => $transactionDto->transaction_date,
                'type'                 => $transactionDto->type,
                'client_id'            => $transactionDto->client_id,
                'payment_provider_id'  => $transactionDto->payment_provider_id,
                'currency'             => $transactionDto->currency ?? 'SAR',
                'transaction_object'   => json_encode($transactionDto->transaction_object),
                'balance_before'       => $balanceBefore,
                'balance_after'        => $balanceAfter,
            ]);

            DB::commit();

            return response()->json('OK');

        }catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Error on saving transaction $transactionDto->reference with exception $exception");
        }
    }
}
