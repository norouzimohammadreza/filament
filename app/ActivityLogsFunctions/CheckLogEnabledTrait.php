<?php

namespace App\ActivityLogsFunctions;

trait CheckLogEnabledTrait
{
    public function checkIfLoggingIsEnabled(): void
    {
        if (ActivityLogHelper::$LOGGING_ENABLED && $this->logLevel >= ActivityLogHelper::$MINIMUM_LOGGING_LEVEL)
            activity()->enableLogging();
        else
            activity()->disableLogging();
    }
}
