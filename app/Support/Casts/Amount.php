<?php

Namespace App\Support\Casts;

use App\Models\Finance\Expense;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Amount implements CastsAttributes
{
    public $before;
    public $expense;

    public function __construct()
    {
        $this->before = '€ ';
        $this->expense = '-';
    }

    public function get($model, $key, $value, $attributes)
    {
        if($model->type === Expense::$TYPES[0]) {
            $this->before = $this->before.$this->expense;
        }

        return $this->before.number_format( $value / 100, 2, ',', '');
    }

    public function set($model, $key, $value, $attributes)
    {
        return ( $value * 100 );
    }
}
