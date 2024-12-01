<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    protected $fillable = [
        'resource',
        'search_query',
        'user_id',
        'ip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
