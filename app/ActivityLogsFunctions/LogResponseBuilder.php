<?php

namespace App\ActivityLogsFunctions;

use App\Enums\LogDetailsAsModelEnum;
use App\Models\LoggingInfo;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\Contracts\Activity as ActivityContract;
use Spatie\Activitylog\Models\Activity;

class LogResponseBuilder
{
    use CheckLogEnabledTrait;

    private ActivityLogger $activityLogger;

    public function __construct(?string $name, int $logLevel)
    {
        $this->logLevel = $logLevel;
        $this->checkIfLoggingIsEnabled();
        $this->activityLogger = activity($name)
            ->tap(function (Activity $activity) {
                if ($this->speciallyUser() != null) {
                    if ($this->speciallyUser()->details == LogDetailsAsModelEnum::ENABLED->value
                        && $this->logLevel >= $this->speciallyUser()->level) {
                        activity()->enableLogging();
                        $activity->level = $this->speciallyUser()->level;
                    } else {
                        activity()->disableLogging();
                    }
                } else {
                    $activity->level = $this->logLevel;
                }
                $activity->ip = inet_pton(request()->ip());
                $activity->url = request()->getPathInfo();
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
        if (isset(auth()->user()->id)){
        $user = LoggingInfo::all()
            ->where('model_type', get_class(auth()->user()))
            ->where('model_id', auth()->user()->id)->first();
        return $user ?? null;
    }}

    public function save(?string $description = null): ?ActivityContract
    {
        return $this->activityLogger->log($description ?? "NO_DESCRIPTION");
    }

}
