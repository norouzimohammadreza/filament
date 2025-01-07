<?php

namespace App\Models;

use App\ActivityLogsFunctions\Traits\MyLogActivityTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

final class Post_Tag extends Pivot
{
    use LogsActivity;


    public $incrementing = true;
    protected $table = 'post_tag';
    protected $fillable = ['post_id', 'tag_id'];

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->level = 1;
        $activity->url = request()->getPathInfo();
        $activity->ip= inet_pton(request()->ip());
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)->logOnlyDirty();
    }
}
