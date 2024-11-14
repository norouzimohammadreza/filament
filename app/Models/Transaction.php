<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use softDeletes;
    protected $fillable = [
        'amount',
        'description',
        'category_id',
    ];
    public function category()
    {
        $this->hasMany(Transaction::class);
    }
}
