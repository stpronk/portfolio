<?php

Namespace App\Support\Casts;

use App\Models\Finance\Expense;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ExpenseType implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return Expense::$TYPES[$value];
    }

    public function set($model, $key, $value, $attributes)
    {
        return Expense::${$value};
    }
}
