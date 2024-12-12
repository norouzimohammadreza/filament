<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelLog extends Model
{
    protected $table = 'model_log_settings';
    protected $fillable = [
        'model_type',
        'is_enabled',
        'logging_level'
    ];
}
