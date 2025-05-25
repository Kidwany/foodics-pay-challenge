<?php

namespace App\Models;

use App\Traits\UuidDefaultValue;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $name
 * @property string $code
 * @property integer $priority
 * @property boolean $supports_incoming
 * @property boolean $supports_outgoing
 * @property string $config
 * @property boolean $is_active
*/
class PaymentProvider extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'payment_providers';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];
}
