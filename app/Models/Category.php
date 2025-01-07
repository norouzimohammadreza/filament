<?php

namespace App\Models;

use App\ActivityLogsFunctions\Traits\MyLogActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
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
        //TODO can we do this with trait?
        $modelLoggingSettings = ModelLogSetting::where('model_type', self::class)->first();
        $this->logLevel = $modelLoggingSettings->logging_level;
        $this->enableLoggingModelsEvents = $modelLoggingSettings->is_enabled;
    }

    public function transactions()
    {
        $this->hasMany(Transaction::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_post')
            ->using(Category_Post::class)
            ->withTimestamps();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty();
    }
}
