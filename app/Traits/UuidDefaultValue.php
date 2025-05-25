<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UuidDefaultValue
{
    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

}
