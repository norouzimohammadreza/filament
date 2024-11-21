<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use  HasFactory,SoftDeletes;
    protected $fillable = [
        'amount',
        'description',
        'category_id',

    ];
    public function category()
    {
       return $this->belongsTo(Category::class);
    }
}
