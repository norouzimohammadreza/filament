<?php

namespace App\ActivityLogsFunctions\Traits;


use App\Models\ModelRecordLogSetting;

trait LogOfSpecificallyModel
{
    use MyLogActivityTrait;

    public function specificallyModel(): ?ModelRecordLogSetting
    {
        $object = ModelRecordLogSetting::where('model_type', get_class($this))
            ->where('model_id', $this->id)->first();
        return $object ?? null;
    }

}
