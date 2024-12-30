<?php

namespace App\ActivityLogsFunctions;

use App\Models\ModelRecordLogSetting;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\ActivityLogStatus;
use Spatie\Activitylog\Contracts\Activity as ActivityContract;
use Spatie\Activitylog\Models\Activity;


class LogResponseBuilder
{

    private ActivityLogger $activityLogger;
    private int $logLevel;

    public function __construct(?string $name, int $logLevel)
    {

        $this->logLevel = $logLevel;
        $this->activityLogger = activity($name)
            ->tap(function (Activity $activity) use ($logLevel) {
                $activity->ip = inet_pton(request()->ip());
                $activity->url = request()->getPathInfo();
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

    protected function checkLogEvent(): bool
    {
        //TODO
        $logStatus = app(ActivityLogStatus::class);
        if (!$logStatus) {
            return false;
        }

        if (!ActivityLogHelper::getInstance()->getAppLoggingIsEnabled()) {
            return false;
        }

        if ($this->speciallyUser() != null) {

            if (!$this->speciallyUser()->is_enabled == 1
                || $this->logLevel < $this->speciallyUser()->logging_level) {
                return false;
            }
            return true;
        }

        if ($this->logLevel < ActivityLogHelper::getInstance()->getAppMinimumLoggingLevel()) {
            return false;
        }
        return true;

    }

    public function speciallyUser()
    {
        if (isset(auth()->user()->id)) {
            $user = ModelRecordLogSetting::all()
                ->where('model_type', get_class(auth()->user()))
                ->where('model_id', auth()->user()->id)->first();
        }
        return $user ?? null;
    }

    public function save(?string $description = null): ?ActivityContract
    {
        return $this->activityLogger->log($description ?? "NO_DESCRIPTION");
    }
}
