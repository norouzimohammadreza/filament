<?php

namespace App\Models;

use App\Traits\LogOfSpecificallyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoggingInfo extends Model
{
    use SoftDeletes, LogOfSpecificallyModel;

    protected $table = 'model_record_log_settings';
    protected $fillable = [
        'model_id',
        'model_type',
        'is_enabled',
        'logging_level'
    ];
    public function model()
    {
        return $this->morphTo();
    }
}
