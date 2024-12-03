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

class Category extends Model
{
    use  HasFactory, SoftDeletes, LogsActivity, CheckLogEnabledTrait;

    protected $fillable = [
        'name',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->logLevel = LogLevelEnum::MEDIUM->value;
        $this->enableLoggingModelsEvents = true;
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $this->checkIfLoggingIsEnabled();
        $activity->ip = inet_pton(request()->ip());
        $activity->url = request()->getPathInfo();
    }

    public function transactions()
    {
        $this->hasMany(Transaction::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_post')->withTimestamps();
    }
    public function logs()
    {
        return $this->morphToMany(Activity::class,'loggable');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty();
    }
}
