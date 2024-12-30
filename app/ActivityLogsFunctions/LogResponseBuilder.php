<?php

namespace App\ActivityLogsFunctions;

use App\Models\ModelRecordLogSetting;
use Illuminate\Support\Arr;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\ActivityLogStatus;
use Spatie\Activitylog\Contracts\Activity as ActivityContract;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class LogResponseBuilder
{
    use LogsActivity;
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
    protected function shouldLogEvent(string $eventName): bool
    {
        //TODO
        $logStatus = app(ActivityLogStatus::class);

        if (!$logStatus) {
            return false;
        }

        if (!ActivityLogHelper::getInstance()->getAppLoggingIsEnabled()){
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
            activity()->disableLogging();
            return true;
        }



        if (!in_array($eventName, ['created', 'updated'])) {
            return true;
        }

        // Do not log update event if the model is restoring
        if ($this->isRestoring()) {
            return false;
        }

        // Do not log update event if only ignored attributes are changed.
        return (bool)count(Arr::except($this->getDirty(), $this->activitylogOptions->dontLogIfAttributesChangedOnly));
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }
}
