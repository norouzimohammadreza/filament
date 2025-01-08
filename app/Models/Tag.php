<?php

namespace App\Models;

use App\ActivityLogsFunctions\Traits\MyLogActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Tag extends Model
{
    use  HasFactory, SoftDeletes;
    use LogsActivity, MyLogActivityTrait {
        MyLogActivityTrait::shouldLogEvent insteadof LogsActivity;
    }

    protected $fillable = [
        'name',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $modelLoggingSettings = $this->getModelLogSetting();
        $this->logLevel = $modelLoggingSettings->logging_level;
        $this->enableLoggingModelsEvents = $modelLoggingSettings->is_enabled;
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag')
            ->using(Post_Tag::class)
            ->withTimestamps();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty();

    }
}
