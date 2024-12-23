<?php

namespace App\Traits;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Enums\LogDetailsAsModelEnum;
use Spatie\Activitylog\Models\Activity;

trait TapLogActivityTrait
{
    public function tapActivity(Activity $activity, string $eventName)
    {
        $this->checkIfLoggingIsEnabled();
        if (($this->specificallyModel() !=null)
            && $this->enableLoggingModelsEvents
            && ActivityLogHelper::$LOGGING_ENABLED
            && $this->specificallyModel() != null) {
            if ($this->specificallyModel()->is_enabled == 1
                && $this->logLevel >= $this->specificallyModel()->logging_level) {
                activity()->enableLogging();
                $activity->level = $this->specificallyModel()->logging_level;
            } else {
                activity()->disableLogging();
            }
        } else if ($this->logLevel >= ActivityLogHelper::$MINIMUM_LOGGING_LEVEL) {
            activity()->enableLogging();
            $activity->level = $this->logLevel;
        }
        $activity->ip = inet_pton(request()->ip());
        $activity->url = request()->getPathInfo();

    }
}
