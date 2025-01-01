<?php

namespace App\ActivityLogsFunctions\Class;

use App\ActivityLogsFunctions\ActivityLogHelper;
use Illuminate\Contracts\Config\Repository;
use Spatie\Activitylog\ActivityLogStatus;

class MyActivityLogStatus extends ActivityLogStatus
{
    public function __construct(Repository $config)
    {
        parent::__construct($config);
        $this->enabled = ActivityLogHelper::getInstance()->getAppLoggingIsEnabled();
    }

}
