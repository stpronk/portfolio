<?php

Namespace App\Support\Casts;

use App\Models\Finance\Expense;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Amount implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return '€ '.number_format( $value  / 100, 2, ',', '');
    }

    public function set($model, $key, $value, $attributes)
    {
        return ( $value * 100 );
    }
}
