<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelLogSetting extends Model
{
    protected $fillable = [
        'model_type',
        'is_enabled',
        'logging_level'
    ];
}
