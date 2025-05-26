<?php

namespace App\Models\Transaction;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $transaction_id
 * @property string $transaction_code
 * @property string $track_id
 * @property string $client_id
 * @property string $payment_provider_id
 * @property string $reference
 * @property double $amount
 * @property double $balance_before
 * @property double $balance_after
 * @property double $currency
 * @property string $type
 * @property string $transaction_date
 * @property string $transaction_object
*/
class Transaction extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'transactions';
}
