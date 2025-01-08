<?php

namespace App\Models;

use App\ActivityLogsFunctions\Traits\MyLogActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaction extends Model
{
    use  HasFactory, SoftDeletes;
    use LogsActivity, MyLogActivityTrait {
        MyLogActivityTrait::shouldLogEvent insteadof LogsActivity;
    }

    protected $fillable = [
        'amount',
        'description',
        'category_id',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $modelLoggingSettings = $this->getModelLogSetting();
        $this->logLevel = $modelLoggingSettings->logging_level;
        $this->enableLoggingModelsEvents = $modelLoggingSettings->is_enabled;
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
