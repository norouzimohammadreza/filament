<?php

namespace App\ActivityLogsFunctions\Traits;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Enums\LogLevelEnum;
use App\Models\ModelLogSetting;
use App\Models\ModelRecordLogSetting;
use Illuminate\Support\Arr;
use Spatie\Activitylog\ActivityLogStatus;
use Spatie\Activitylog\Models\Activity;

trait MyLogActivityTrait
{
    public int $logLevel = LogLevelEnum::LOW->value;
    public function setLevelByEvent(string $eventName) : int
    {
        //TODO logging based on event type!?
        switch ($eventName) {
            case 'created' :
                $event_log_level = LogLevelEnum::MEDIUM->value;
                break;
            case 'updated' :
                $event_log_level = LogLevelEnum::HIGH->value;
                break;
            case 'deleted' :
                $event_log_level = LogLevelEnum::CRITICAL->value;
                break;
        }
        return $event_log_level;
    }
    public function tapActivity(Activity $activity, string $eventName, int $event_log_level = LogLevelEnum::LOW->value)
    {
        $activity->ip = inet_pton(request()->ip());
        $activity->url = request()->getPathInfo();
        $event_log_level = $this->setLevelByEvent($eventName);


        if (!ActivityLogHelper::getInstance()->getAppLoggingIsEnabled()) {
            activity()->disableLogging();
            return;
        }


        if ($this->modelLogSetting()->follow_global_config == 1) {
            if ($event_log_level < ActivityLogHelper::getInstance()->getAppMinimumLoggingLevel()) {
                activity()->disableLogging();
                return;
            }
            activity()->enableLogging();
            $activity->level = $event_log_level;
            return;
        }

        if($event_log_level < $this->logLevel){
            activity()->disableLogging();
            return;
        }
        activity()->enableLogging();
        $activity->level = $event_log_level;
    }

    protected function shouldLogEvent(string $eventName): bool
    {
        //TODO
        $logStatus = app(ActivityLogStatus::class);
        $event_log_level = $this->setLevelByEvent($eventName);
        if ($this->modelRecordLogSettings != null) {
            if (!$this->modelRecordLogSettings->is_enabled || $event_log_level < $this->modelRecordLogSettings->logging_level) {
                activity()->disableLogging();
                return false;
            }
            $this->enableLogging();
            activity()->enableLogging();
            \activity()->tap(function (Activity $activity) use ($event_log_level) {
               $activity->level = $event_log_level;
            });
            return true;
        }

        //TODO where set?
        if (!$this->enableLoggingModelsEvents) {
            activity()->disableLogging();
            return false;
        }


        if (! in_array($eventName, ['created', 'updated'])) {
            return true;
        }

        // Do not log update event if the model is restoring
        if ($this->isRestoring()) {
            return false;
        }

        // Do not log update event if only ignored attributes are changed.
        return (bool) count(Arr::except($this->getDirty(), $this->activitylogOptions->dontLogIfAttributesChangedOnly));
    }

    public function modelLogSetting(): ModelLogSetting
    {
        //dd(get_class($this));
        return ModelLogSetting::where('model_type', get_class($this))->firstOrFail();
    }
    public function modelRecordLogSettings()
    {
        return $this->morphOne(ModelRecordLogSetting::class,'model');
    }
}
