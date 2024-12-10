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
        if ($this->enableLoggingModelsEvents
            && ActivityLogHelper::$LOGGING_ENABLED
            && $this->specificallyModel() != null) {
            if ($this->specificallyModel()->details == LogDetailsAsModelEnum::ENABLED->value
                && $this->logLevel >= $this->specificallyModel()->level) {
                activity()->enableLogging();
                $activity->level = $this->specificallyModel()->level;
            } else {
                activity()->disableLogging();
            }
        } else {
            $activity->level = $this->logLevel;
        }
        $activity->ip = inet_pton(request()->ip());
        $activity->url = request()->getPathInfo();

    }
}
