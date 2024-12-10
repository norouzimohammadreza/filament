<?php

namespace App\Models;

use App\Traits\LogOfSpecificallyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoggingInfo extends Model
{
    use SoftDeletes, LogOfSpecificallyModel;

    protected $table = 'model_logging_details';
    protected $fillable = [
        'model_id',
        'model_type',
        'details',
        'level'
    ];
    public function model()
    {
        return $this->morphTo();
    }
}
