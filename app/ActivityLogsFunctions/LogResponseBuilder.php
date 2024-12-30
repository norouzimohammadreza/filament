<?php

namespace App\ActivityLogsFunctions;

use App\Models\ModelRecordLogSetting;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\Contracts\Activity as ActivityContract;
use Spatie\Activitylog\Models\Activity;

class LogResponseBuilder
{
    private ActivityLogger $activityLogger;

    public function __construct(?string $name, int $logLevel)
    {
        $this->activityLogger = activity($name)
            ->tap(function (Activity $activity) use ($logLevel) {

                $activity->ip = inet_pton(request()->ip());
                $activity->url = request()->getPathInfo();


                if (!ActivityLogHelper::getInstance()->getAppLoggingIsEnabled()){
                    activity()->disableLogging();
                    return;
                }

                if ($this->speciallyUser() != null) {
                    if (!$this->speciallyUser()->is_enabled == 1
                        || $logLevel < $this->speciallyUser()->logging_level) {
                        activity()->disableLogging();
                        return;
                    }
                    activity()->enableLogging();
                    $activity->level = $logLevel;
                    return;
                    }

                if ($logLevel < ActivityLogHelper::getInstance()->getAppMinimumLoggingLevel()) {
                    activity()->disableLogging();
                    return;
                    }
                activity()->enableLogging();
                $activity->level = $logLevel;

            });
    }


    public function withEvent(string $event)
    {
        $this->activityLogger->event($event);
        return $this;
    }

    public function withProperties(array $properties)
    {
        $this->activityLogger->withProperties($properties);
        return $this;
    }

    public function withSubject(mixed $subject)
    {
        $this->activityLogger->performedOn($subject);
        return $this;
    }

    public function withTap(string $name, string $value)
    {
        $this->activityLogger->tap(function (Activity $activity) use ($name, $value) {
            $activity->$name = $value;
        });
        return $this;
    }

    public function speciallyUser()
    {
        if (isset(auth()->user()->id)) {
            $user = ModelRecordLogSetting::all()
                ->where('model_type', get_class(auth()->user()))
                ->where('model_id', auth()->user()->id)->first();
            return $user ?? null;
        }
    }

    public function save(?string $description = null): ?ActivityContract
    {
        return $this->activityLogger->log($description ?? "NO_DESCRIPTION");
    }

}
