<?php

namespace App\Models;

use App\ActivityLogsFunctions\Traits\MyLogActivityTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

final class Post_Tag extends Pivot
{
    use LogsActivity, MyLogActivityTrait {
        MyLogActivityTrait::shouldLogEvent insteadof LogsActivity;
    }


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
        $this->logLevel = ModelLogSetting::where('model_type', Post::class)
            ->first()->logging_level;
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
