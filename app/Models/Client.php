<?php

namespace App\Models;

use App\Traits\UuidDefaultValue;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $reference
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $balance
 * @property string $reserved_balance
 * @property string $KYC_data
 * @property boolean $is_active
*/
class Client extends BaseModel
{
    use UuidDefaultValue, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'clients';
    /**
     * @var bool
     */
    public $incrementing = false;
    /**
     * @var string
     */
    protected $keyType = 'string';
}
