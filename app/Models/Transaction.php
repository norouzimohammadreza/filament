<?php

namespace App\Models;

use App\ActivityLogsFunctions\ActivityLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaction extends Model
{
    use  HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'amount',
        'description',
        'category_id',

    ];

    public function tapActivity(Activity $activity, string $eventName)
    {
        ActivityLogHelper::toggleLog();
        $activity->ip = inet_pton(request()->ip());
        $activity->url = request()->getPathInfo();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['amount', 'description', 'category.name'])
            ->logOnlyDirty()
            ->useLogName('Crud on Transaction');

    }
}
