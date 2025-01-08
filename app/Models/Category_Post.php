<?php

namespace App\Models;

use App\ActivityLogsFunctions\Traits\MyLogActivityTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

final class Category_Post extends Pivot
{
    protected $table = 'category_post';
    use LogsActivity, MyLogActivityTrait {
        MyLogActivityTrait::shouldLogEvent insteadof LogsActivity;
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->enableLoggingModelsEvents
            = ModelLogSetting::where('model_type', Post::class)->first()->is_enabled;
        $this->logLevel = ModelLogSetting::where('model_type', Post::class)
            ->first()->logging_level;
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


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'category.name',
                'post.title',
            ])->logOnlyDirty();
    }
}
