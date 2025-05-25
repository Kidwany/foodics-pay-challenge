<?php

namespace App\Models;

use App\Traits\ActiveQueryScope;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use ActiveQueryScope;
}
