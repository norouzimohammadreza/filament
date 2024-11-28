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
        $a = new LogResponseBuilder(new LogResponse());
        $a->withName('HTTP')->withEvent('HTTP Response')->withProperties([
            'getStatusCode' => $response->getStatusCode()
        ])->withLevel(0)->logging();
//        self::log('HTTP',
//            'HTTP Response',
//            'HTTP Response',
//            [
//                'getStatusCode' => $response->getStatusCode()
//            ],
//            LogLevelEnum::Low->value
//        );
    }

    public static function logErrorResponse(Response $response)
    {
        self::toggleLog();
        $a = new LogResponseBuilder(new LogResponse());

        /*self::log('HTTP',
            'HTTP Error Response',
            'HTTP Error Response',
            [
                'getStatusCode' => $response->getStatusCode()
            ],
            LogLevelEnum::MEDIUM->value

        );*/
    }


    public static function toggleLog()
    {
        $toggle = true;
        if (!$toggle) {
           return activity()->disableLogging();
        }
        return activity()->enableLogging();
    }
    public function LogAsLevel()
    {
        //self::log();

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
