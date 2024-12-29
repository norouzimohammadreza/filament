<?php

namespace App\Models;

use App\ActivityLogsFunctions\Traits\CheckLogEnabledTrait;
use App\ActivityLogsFunctions\Traits\LogOfSpecificallyModel;
use App\ActivityLogsFunctions\Traits\MyLogActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaction extends Model
{
    use  HasFactory, SoftDeletes, LogsActivity, CheckLogEnabledTrait, LogOfSpecificallyModel
        , MyLogActivityTrait;

    protected $fillable = [
        'amount',
        'description',
        'category_id',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->logLevel = ModelLogSetting::where('model_type', self::class)->first()->logging_level;
        $this->enableLoggingModelsEvents = ModelLogSetting::where('model_type', self::class)->first()->is_enabled;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['amount', 'description', 'category.name'])
            ->logOnlyDirty()
            ->useLogName('Crud on Transaction');

    }
}
