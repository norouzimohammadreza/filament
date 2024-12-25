<?php

namespace App\ActivityLogsFunctions\Traits;

use App\ActivityLogsFunctions\ActivityLogHelper;
use Spatie\Activitylog\Models\Activity;

trait TapLogActivityTrait
{
    public function tapActivity(Activity $activity, string $eventName, int $level)
    {
        if (ActivityLogHelper::$LOGGING_ENABLED
            && $this->enableLoggingModelsEvents) {
            if ($this->specificallyModel() != null) {
                if ($this->specificallyModel()->is_enabled == 1
                    && $level >= $this->specificallyModel()->logging_level) {
                    activity()->enableLogging();
                    $activity->level = $level;
                }else{
                    activity()->disableLogging();
                }
            } else if ($level >= $this->logLevel) {
                activity()->enableLogging();
                $activity->level = $level;
            }else{
                activity()->disableLogging();
            }
        } else {
            activity()->disableLogging();
        }
        $activity->ip = inet_pton(request()->ip());
        $activity->url = request()->getPathInfo();

    }

    public function activity(Activity $activity, string $eventName, int $level)
    {

    }
}
