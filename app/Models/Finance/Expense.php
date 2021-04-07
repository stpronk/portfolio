<?php

namespace App\Models\Finance;

use App\Support\Casts\Amount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\Casts\ExpenseType;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'finance_expense';

    protected $guarded = [];

    protected $with = ['Category'];

    protected $appends = ['rawData'];

    static public $EXPENSE = 0;
    static public $INCOME = 1;

    static public $TYPES = [
        0 => 'EXPENSE',
        1 => 'INCOME'
    ];

    protected $casts = [
        'finance_category_id' => 'integer',
        'finance_group_id'    => 'integer',
        'amount'              => Amount::class,
        'type'                => ExpenseType::class,
        'date'                => 'date:d/m/Y',
        'created_at'          => 'datetime:Y-m-d H:i:s',
        'updated_at'          => 'datetime:Y-m-d H:i:s',
        'deleted_at'          => 'datetime:Y-m-d H:i:s',
        'rawData'             => 'array',
    ];

    /**
     * CASTS
     */
    public function getRawDataAttribute () {
        return [
            'amount' => ($this->getRawOriginal('amount') / 100),
            'date'   => $this->getRawOriginal('date')
        ];
    }

    /**
     * RELATIONS
     */
    public function Group ()
    {
        return $this->belongsTo(Group::class, 'finance_group_id', 'id');
    }

    public function Category ()
    {
        return $this->belongsTo(Category::class, 'finance_category_id', 'id');
    }
}
