<?php

namespace App\ActivityLogsFunctions\Traits;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Enums\LogLevelEnum;
use App\Models\ModelLogSetting;
use Spatie\Activitylog\Models\Activity;

trait MyLogActivityTrait
{
    public function tapActivity(Activity $activity, string $eventName, int $event_log_level = LogLevelEnum::LOW->value)
    {
        $activity->ip = inet_pton(request()->ip());
        $activity->url = request()->getPathInfo();

//TODO logging based on event type!?
        switch ($eventName) {
            case 'created' :
                $level = LogLevelEnum::MEDIUM->value;
                break;
            case 'updated' :
                $level = LogLevelEnum::HIGH->value;
                break;
            case 'deleted' :
                $level = LogLevelEnum::CRITICAL->value;
                break;
        }

        if (!ActivityLogHelper::getInstance()->getAppLoggingIsEnabled()) {
            activity()->disableLogging();
            return;
        }

        if ($this->modelRecordLogSettings != null) {
            if (!$this->modelRecordLogSettings->is_enabled || $event_log_level < $this->specificallyModel()->logging_level) {
                activity()->disableLogging();
                return;
            }
            $activity->level = $event_log_level;
            activity()->enableLogging();
            return;
        }

        //TODO where set?
        if (!$this->enableLoggingModelsEvents) {
            activity()->disableLogging();
            return;
        }

        if ($this->modelLogSetting->follow_global_config) {
            if ($event_log_level < ActivityLogHelper::getInstance()->getAppMinimumLoggingLevel()) {
                activity()->disableLogging();
                return;
            }
            $activity->level = $event_log_level;
            activity()->enableLogging();
            return;
        }


        if($event_log_level < $this->logLevel){
            activity()->disableLogging();
            return;
        }

        $activity->level = $event_log_level;
        activity()->enableLogging();
    }

    public function modelLogSetting(): ModelLogSetting
    {
        return ModelLogSetting::where('model_type', get_class($this))->firstOrFail();
    }
}
