<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoggingInfo extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'model_id',
        'model_type',
        'details',
        'level'
    ];
}
