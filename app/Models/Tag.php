<?php

namespace App\Models;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\ActivityLogsFunctions\Traits\CheckLogEnabledTrait;
use App\ActivityLogsFunctions\Traits\LogOfSpecificallyModel;
use App\Enums\LogLevelEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Tag extends Model
{
    use  HasFactory, SoftDeletes, LogsActivity, CheckLogEnabledTrait, LogOfSpecificallyModel;

    protected $fillable = [
        'name',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->logLevel = ModelLog::where('model_type', self::class)->first()->logging_level;
        $this->enableLoggingModelsEvents = ModelLog::where('model_type', self::class)->first()->is_enabled;
    }

    public function tapActivity(Activity $activity, string $eventName,int $level = LogLevelEnum::LOW->value)
    {
        switch ($eventName) {
            case 'created' : $level = LogLevelEnum::MEDIUM->value; break;
            case 'updated' : $level = LogLevelEnum::HIGH->value;break;
            case 'deleted' : $level = LogLevelEnum::CRITICAL->value;break;
        }
        $this->checkIfLoggingIsEnabled();
        if(ActivityLogHelper::$LOGGING_ENABLED)
        {
            if ($this->enableLoggingModelsEvents
                && $level >= $this->logLevel ){
                activity()->enableLogging();
                $activity->level = $level;
            }
        }
        else{
            activity()->disableLogging();
        }
        $activity->ip = inet_pton(request()->ip());
        $activity->url = request()->getPathInfo();
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag')->withTimestamps();
    }

    public function logs()
    {
        return $this->morphToMany(LoggingInfo::class, 'model');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty();

    }
}
