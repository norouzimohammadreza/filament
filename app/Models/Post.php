<?php

namespace App\Models;

use App\ActivityLogsFunctions\Traits\MyLogActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Post extends Model
{
    use  HasFactory, SoftDeletes;
    use LogsActivity, MyLogActivityTrait {
        MyLogActivityTrait::shouldLogEvent insteadof LogsActivity;
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $modelLoggingSettings = $this->getModelLogSetting();
        $this->logLevel = $modelLoggingSettings->logging_level;
        $this->enableLoggingModelsEvents = $modelLoggingSettings->is_enabled;
    }

    protected $fillable = [
        'title',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag')
            ->using(Post_Tag::class)
            ->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post')
            ->using(Category_Post::class)
            ->withTimestamps();
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)->logOnlyDirty();

    }
}
