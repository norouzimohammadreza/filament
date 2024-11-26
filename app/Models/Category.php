<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use  HasFactory,SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
    ];

    public function transactions()
    {
        $this->hasMany(Transaction::class);
    }
    public function posts()
    {
        return $this->belongsToMany(Post::class,'category_post')->withTimestamps();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->setDescriptionForEvent(fn(string $eventName) => "category has been {$eventName}");


    }
}
