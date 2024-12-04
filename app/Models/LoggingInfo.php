<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoggingInfo extends Model
{
    protected $fillable = [
        'model_id',
        'model_type',
        'details',
        'level'
    ];
}
