<?php

namespace App\Traits;


use App\Enums\LogDetailsAsModelEnum;
use App\Models\LoggingInfo;

trait LogOfSpecificallyModel
{

    public function specificallyModel(): ?LoggingInfo
    {
        $object = LoggingInfo::all()
            ->where('model_type', get_class($this))
            ->where('model_id', $this->id)->first();
        return $object ?? null;
    }

    public function checkModelLogger()
    {
        //$tmpMinimumLoggingLevel = ActivityLogHelper::$MINIMUM_LOGGING_LEVEL;
    }
}
