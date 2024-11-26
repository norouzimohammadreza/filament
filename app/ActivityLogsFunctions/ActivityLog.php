<?php

namespace App\ActivityLogsFunctions;

use App\Models\User;
use Spatie\Activitylog\Models\Activity;

class ActivityLog
{
    public function setLog(?User $user, string $url, array $queryString, int $statusCode)
    {
        activity('user log')
            ->causedBy($user)
            ->event('User activity log')
            ->withProperties([
                'url' => $url,
                'queryString' => $queryString,
                'getStatusCode' => $statusCode,
            ])->tap(function (Activity $activity) {
                $activity->ip = inet_pton(request()->ip());
            })
            ->log(' with ip:' . request()->ip() . ' on ' . $url)
            ->subject();
    }
}
