<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

final class Category_Post extends Pivot
{
    protected $table = 'category_post';
    use LogsActivity;
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->enableLoggingModelsEvents
            = ModelLogSetting::where('model_type', Post::class)->first()->is_enabled;
    }

    protected $fillable = [
        'post_id',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->level = 1;
        $activity->url = request()->getPathInfo();
        $activity->ip = inet_pton(request()->ip());
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'category.name',
                'post.title',
                ])->logOnlyDirty();
    }
}
