<?php

namespace App\ActivityLogsFunctions;

use Spatie\Activitylog\Models\Activity;
use Symfony\Component\HttpFoundation\Response;

class ActivityLogHelper
{
    public static function logResponse(Response $response)
    {
        self::log('HTTP',
            request()->getPathInfo(),
            'HTTP Response',
            [
                'getStatusCode' => $response->getStatusCode()
            ]
        );
    }

    public static function logErrorResponse(Response $response)
    {
        self::log('HTTP',
            request()->getPathInfo(),
            'HTTP Error Response',
            [
                'getStatusCode' => $response->getStatusCode()
            ]
        );
    }

    private static function log(string $name, string $description, string $event, array $properties)
    {
        $log = activity('HTTP')
            ->event('HTTP Error Response')
            ->withProperties([
                'url' => request()->getPathInfo(),
                'queryString' => request()->query() ?? null,
                ...$properties
            ])->tap(function (Activity $activity) {
                $activity->ip = inet_pton(request()->ip());
            });

        if (auth()->check()) {
            $log->causedBy(auth()->user());
        }

        $log->log(request()->getPathInfo());
    }

    public static function getViewUrl(Activity $activity): ?string
    {
        return match ($activity->subject_type) {
            'App\Models\Post' => route('filament.admin.resources.posts.edit', $activity->subject_id),
            'App\Models\User' => route('filament.admin.resources.users.edit', $activity->subject_id),
            'App\Models\Tag' => route('filament.admin.resources.tags.edit', $activity->subject_id),
            'App\Models\Category' => route('filament.admin.resources.categories.edit', $activity->subject_id),
            'App\Models\Transaction' => route('filament.admin.resources.transactions.edit', $activity->subject_id),
            null => url($activity->description),
            default => null
        };
    }
}
