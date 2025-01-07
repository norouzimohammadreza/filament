<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

final class Category_Post extends Pivot
{
    protected $table = 'category_post';
    use LogsActivity;
    protected $fillable = [
        'post_id',
        'category_id',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)->logOnlyDirty();
    }
}
