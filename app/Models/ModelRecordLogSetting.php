<?php

namespace App\Models;

use App\ActivityLogsFunctions\Traits\LogOfSpecificallyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelRecordLogSetting extends Model
{
    use SoftDeletes;
    use LogOfSpecificallyModel;

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
