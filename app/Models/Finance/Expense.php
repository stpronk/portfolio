<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'finance_expense';

    protected $guarded = [];

    static public $EXPENSE = 0;
    static public $INCOME = 1;

    static public $TYPES = [
        0 => 'EXPENSE',
        1 => 'INCOME'
    ];

    protected $casts = [
        'finance_category_id' => 'integer',
        'finance_group_id' => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function getTypeNameAttribute ()
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
