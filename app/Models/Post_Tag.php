<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

final class Post_Tag extends Pivot
{
    use LogsActivity;


    public $incrementing = true;
    protected $table = 'post_tag';
    protected $fillable = [
        'post_id',
        'tag_id',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->enableLoggingModelsEvents
            = ModelLogSetting::where('model_type', Post::class)->first()->is_enabled;
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->level = 1;
        $activity->url = request()->getPathInfo();
        $activity->ip = inet_pton(request()->ip());
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(
                [
                    'tag.name',
                    'post.title',
                ]
            )->logOnlyDirty();
    }
}
