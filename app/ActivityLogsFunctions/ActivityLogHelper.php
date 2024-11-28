<?php

namespace App\ActivityLogsFunctions;

use App\Enums\LogLevelEnum;
use Spatie\Activitylog\Models\Activity;
use Symfony\Component\HttpFoundation\Response;

class ActivityLogHelper
{
    public static function logResponse(Response $response)
    {
        self::toggleLog();
        self::log('HTTP',
            'HTTP Response',
            'HTTP Response',
            [
                'getStatusCode' => $response->getStatusCode()
            ],
            LogLevelEnum::Low->value
        );
    }

    public static function logErrorResponse(Response $response)
    {
        self::toggleLog();
        self::log('HTTP',
            'HTTP Error Response',
            'HTTP Error Response',
            [
                'getStatusCode' => $response->getStatusCode()
            ],
            LogLevelEnum::MEDIUM->value

        );
    }

    private static function log(string $name, string $description,
                                string $event, array $properties, int $logLevel)
    {
        $log = activity($name)
            ->event($event)
            ->withProperties([
                'url' => request()->getPathInfo(),
                'queryString' => request()->query() ?? null,
                ...$properties
            ])->tap(function (Activity $activity) use ($logLevel) {
                $activity->ip = inet_pton(request()->ip());
                $activity->url = request()->getPathInfo();
                $activity->level = $logLevel ;
            });

        if (auth()->check()) {
            $log->causedBy(auth()->user());
        }

        $log->log($description);
    }
    public static function toggleLog(bool $toggle=false)
    {
        if ($toggle == false) {
           return activity()->disableLogging();
        }
        return activity()->enableLogging();

    }

    public static function getViewUrl(Activity $activity): ?string
    {
        return match ($activity->subject_type) {
            'App\Models\Post' => route('filament.admin.resources.posts.edit', $activity->subject_id),
            'App\Models\User' => route('filament.admin.resources.users.edit', $activity->subject_id),
            'App\Models\Tag' => route('filament.admin.resources.tags.edit', $activity->subject_id),
            'App\Models\Category' => route('filament.admin.resources.categories.edit', $activity->subject_id),
            'App\Models\Transaction' => route('filament.admin.resources.transactions.edit', $activity->subject_id),
            null => url($activity->url),
            default => null
        };
    }
}
