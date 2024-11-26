<?php

namespace App\ActivityLogsFunctions;

use App\Models\User;

class ActivityLog
{
    public function setLog(User $user,string $url,string $queryString,int $statusCode)
    {
        activity()
            ->causedBy($user)
            ->event('User activity log')
            ->withProperties([
                'url' => $url,
                'queryString' => $queryString,
                'getStatusCode' => $statusCode,
            ])
            ->log($user->name .' on ' . $url . ' with query string ' . $queryString)
        ->subject($user);
    }
}
