<?php

namespace App\Traits;


use App\ActivityLogsFunctions\ActivityLogHelper;
use App\Enums\LogDetailsAsModelEnum;
use App\Models\LoggingInfo;

trait LogOfSpecificallyModel
{

    public function checkValue()
    {
       $object = LoggingInfo::all()
           ->where('model_type',get_class($this))
           ->where('model_id', $this->id)->first();
       if ($object && $object->details == LogDetailsAsModelEnum::ENABLED->value) {
           ActivityLogHelper::log('Specifically Log',$object->level)
               ->withProperties([
                   'status_code' => response()->getStatusCode(),
               ])
               ->save();
       }else{
           return null;
       }
    }

}
