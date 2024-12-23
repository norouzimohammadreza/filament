<?php

namespace App\ActivityLogsFunctions\Traits;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Enums\LogLevelEnum;

trait CheckLogEnabledTrait
{
    public int $logLevel = LogLevelEnum::LOW->value;

    public function checkIfLoggingIsEnabled(): void
    {
        if (ActivityLogHelper::$LOGGING_ENABLED
            && $this->logLevel >= ActivityLogHelper::$MINIMUM_LOGGING_LEVEL){
            activity()->enableLogging();

       }else
            activity()->disableLogging();
    }
}
