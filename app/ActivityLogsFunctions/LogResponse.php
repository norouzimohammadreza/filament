<?php

namespace App\ActivityLogsFunctions;

use App\Enums\LogLevelEnum;
use Spatie\Activitylog\Models\Activity;

class LogResponse
{
    private string $name = 'Http';
    private string $description = '';
    private ?string $event = null;
    private array $properties = [];
    private int $level = LogLevelEnum::Low->value;

    public function setName(string $name): string
    {
        return $this->name = $name;
    }

    public function setDescription(string $description): string
    {
        return $this->description = $description;
    }

    public function setEvent(?string $event): ?string
    {
        return $this->event = $event;
    }

    public function setProperties(array $properties): array
    {
        return $this->properties = $properties;
    }

    public function setLevel(int $level): int
    {
        return $this->level = $level;
    }

    public static function log()
    {
        $log = activity(LogResponse::class->name)
            ->event(LogResponse::class->event)
            ->withProperties([
                'url' => request()->getPathInfo(),
                'queryString' => request()->query() ?? null,
                ...LogResponse::class->properties
            ])->tap(function (Activity $activity) {
                $activity->ip = inet_pton(request()->ip());
                $activity->url = request()->getPathInfo();
                $activity->level = LogResponse::class->level;
            });

        if (auth()->check()) {
            $log->causedBy(auth()->user());
        }

        $log->log(LogResponse::class->description);
    }

}
