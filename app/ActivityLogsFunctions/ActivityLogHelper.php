<?php

namespace App\ActivityLogsFunctions;

use App\Enums\LogLevelEnum;
use Spatie\Activitylog\Models\Activity;

class ActivityLogHelper
{
    public static bool $LOGGING_ENABLED = true;
    public static int $MINIMUM_LOGGING_LEVEL = LogLevelEnum::MEDIUM->value;

    public static function log(string $name)
    {
        return new LogResponseBuilder($name, self::$MINIMUM_LOGGING_LEVEL);
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
