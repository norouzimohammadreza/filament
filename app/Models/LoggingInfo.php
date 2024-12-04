<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoggingInfo extends Model
{
    use SoftDeletes;
    protected $table = 'model_logging_details';
    protected $fillable = [
        'model_id',
        'model_type',
        'details',
        'level'
    ];
}
