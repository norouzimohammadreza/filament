<?php

namespace App\ActivityLogsFunctions\Traits;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Enums\LogLevelEnum;
use Spatie\Activitylog\Models\Activity;

trait CheckLogEnabledTrait
{
    public int $logLevel = LogLevelEnum::LOW->value;

    public function checkIfLoggingIsEnabled(): void
    {
        if (ActivityLogHelper::getInstance()->getAppLoggingIsEnabled()){
            activity()->enableLogging();

       }else
            activity()->disableLogging();
    }

}
