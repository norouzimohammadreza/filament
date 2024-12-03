<?php

namespace App\ActivityLogsFunctions;


use Spatie\Activitylog\Models\Activity;


class LogResponse
{
    private string $name = 'Http';
    private string $description = '';
    private string $event = '';
    private array $properties = [];
    private int $level;

    public function setName(string $name): string
    {
        return $this->name = $name;
    }

    public function setDescription(string $description): string
    {
        return $this->description = $description;
    }

    public function setEvent(string $event): string
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

//    public function getLevel(): int
//    {
//        return $this->level;
//    }

    public function response()
    {
        $log = activity($this->name)
            ->event($this->event)
            ->withProperties([
                'queryString' => request()->getQueryString(),
                ...$this->properties
            ])->tap(function (Activity $activity) {
                $activity->ip = inet_pton(request()->ip());
                $activity->url = request()->getPathInfo();
                $activity->level = $this->level;
            });

        if (auth()->check()) {
            $log->causedBy(auth()->user());
        }

        $log->log($this->description);
    }

}
