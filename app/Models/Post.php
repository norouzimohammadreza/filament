<?php

namespace App\Models;

use App\ActivityLogsFunctions\CheckLogEnabledTrait;
use App\Enums\LogLevelEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Post extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, CheckLogEnabledTrait;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->logLevel = LogLevelEnum::MEDIUM->value;
        $this->enableLoggingModelsEvents = false;
    }

    protected $fillable = [
        'title',
        'user_id',
        'category_id',
    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $this->checkIfLoggingIsEnabled();
        $activity->ip = inet_pton(request()->ip());
        $activity->url = request()->getPathInfo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag')->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post')->withTimestamps();
    }
    public function logs()
    {
        return $this->morphToMany(LoggingInfo::class,'model');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty();

    }
}
