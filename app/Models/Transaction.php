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

    ];
    public function category()
    {
       return $this->belongsTo(Category::class);
    }
}
