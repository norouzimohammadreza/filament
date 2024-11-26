<?php

namespace App\ActivityLogsFunctions;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Transaction;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;

class ActivityLog
{
    public function setLog(?User $user, string $url, array $queryString, int $statusCode)
    {
        activity('user log')
            ->causedBy($user)
            ->performedOn($user)
            ->event('User activity log')
            ->withProperties([
                'url' => $url,
                'queryString' => $queryString,
                'getStatusCode' => $statusCode,
            ])->tap(function (Activity $activity) {
                $activity->ip = inet_pton(request()->ip());
            })
            ->log(' route: ' . $url);
    }

    public static function getSubjectUrl($subjectClass, $subjectId): ?string
    {
        return match ($subjectClass) {
            'App\Models\Post' => route('filament.admin.resources.posts.edit', $subjectId),
            'App\Models\User' => route('filament.admin.resources.users.edit', $subjectId),
            'App\Models\Tag' => route('filament.admin.resources.tags.edit', $subjectId),
            'App\Models\Category' => route('filament.admin.resources.categories.edit', $subjectId),
            'App\Models\Transaction' => route('filament.admin.resources.transactions.edit', $subjectId),
            default => null
        };
    }
}
