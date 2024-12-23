<?php

namespace App\ActivityLogsFunctions\Traits;


use App\Models\LoggingInfo;

trait LogOfSpecificallyModel
{
    use TapLogActivityTrait;

    public function specificallyModel(): ?LoggingInfo
    {
        $object = LoggingInfo::all()
            ->where('model_type', get_class($this))
            ->where('model_id', $this->id)->first();
        return $object ?? null;
    }

}
