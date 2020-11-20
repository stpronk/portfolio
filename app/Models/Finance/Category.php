<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

class Category extends Model
{
    use HasFactory;

    protected $table = 'finance_category';

    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable = [
        'name', 'color', 'finance_group_id'
    ];

    protected $casts = [
        'finance_group_id' => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     * RELATIONS
     */
    public function Group ()
    {
        return $this->belongsTo( Group::class, 'finance_group_id', 'id');
    }

    public function Expenses ()
    {
        return $this->hasMany(Expense::class, 'finance_category_id', 'id');
    }

}
