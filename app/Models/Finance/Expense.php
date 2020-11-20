<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'finance_expense';

    static public $EXPENSE = 0;
    static public $INCOME = 1;

    static public $TYPES = [
        0 => 'EXPENSE',
        1 => 'INCOME'
    ];

    public function getTypeAttribute ()
    {
        return self::$TYPES[$this->type];
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
