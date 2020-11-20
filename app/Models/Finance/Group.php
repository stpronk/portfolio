<?php

namespace App\Models\Finance;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'finance_group';

    public $casts = [
        'owner_id' => 'integer'
    ];

    /**
     * RELATIONS
     */
    public function Owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function Categories()
    {
        return $this->hasMany(Category::class, 'finance_group_id', 'id');
    }

    public function Expenses()
    {
        return $this->hasMany(Expense::class, 'finance_group_id','id');
    }
}
