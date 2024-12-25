<?php

namespace App\ActivityLogsFunctions;

use App\Enums\LogLevelEnum;
use App\Models\ModelLog;
use Spatie\Activitylog\Models\Activity;

class ActivityLogHelper
{
    private bool $AppLoggingEnabled;
    private int $AppMinimumLoggingLevel;

    private static ?ActivityLogHelper $instance = null;

    public static function getInstance(): ActivityLogHelper
    {
        if (self::$instance === null) {
            self::$instance = new ActivityLogHelper();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $fakeAppModel = ModelLog::where('model_type', 'App')
            ->firstOrCreate([
                'model_type' => 'App',
            ]);
        $this->AppLoggingEnabled = $fakeAppModel->is_enabled;
        $this->AppMinimumLoggingLevel = $fakeAppModel->logging_level;
    }

    public function getAppLoggingIsEnabled()
    {
        return $this->AppLoggingEnabled;
    }

    public function getAppMinimumLoggingLevel()
    {
        return $this->AppMinimumLoggingLevel;
    }

    public function log(string $name, $logLevel = LogLevelEnum::MEDIUM->value)
    {
        return new LogResponseBuilder($name, $logLevel);
    }

    public function getViewUrl(Activity $activity): ?string
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
