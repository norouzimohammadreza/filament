<?php

namespace App\ActivityLogsFunctions;

use App\Enums\LogLevelEnum;
use Spatie\Activitylog\Models\Activity;
use Symfony\Component\HttpFoundation\Response;

class ActivityLogHelper
{
    private static bool $toggle = true;
    public static function logResponse(Response $response)
    {
        self::toggleLog();
        self::LogAsLevel();
        $logger = new LogResponseBuilder();
        $logger
            ->withName('HTTP')
            ->withEvent('HTTP Response')
            ->withDescription('HTTP Response')
            ->withProperties([
                'getStatusCode' => $response->getStatusCode()
            ])->withLevel(3)->log()->response();

    }

    public static function logErrorResponse(Response $response)
    {
        self::toggleLog();
        //self::LogAsLevel();
        $logger = new LogResponseBuilder(new LogResponse());
        $logger->withName('HTTP')->withEvent('HTTP Error Response')
            ->withDescription('HTTP Error Response')->withProperties([
                'getStatusCode' => $response->getStatusCode()
            ])->withLevel(0)->log()->response();
    }


    public static function toggleLog()
    {
        if (!ActivityLogHelper::$toggle) {
            return activity()->disableLogging();
        }
        return activity()->enableLogging();
    }

    public static function LogAsLevel()
    {
        $logger = new LogResponse();
        $level = $logger->getLevel();
        dd($level);
        if ($level > LogLevelEnum::MEDIUM->value) {
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
