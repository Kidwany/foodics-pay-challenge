<?php

namespace App\Traits;

trait ActiveQueryScope
{
    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query): mixed
    {
        return $query->where('is_active', true);
    }
}
