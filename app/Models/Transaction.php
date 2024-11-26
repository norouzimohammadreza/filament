<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaction extends Model
{
    use  HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'amount',
        'description',
        'category_id',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['amount', 'description', 'category.name'])
            ->setDescriptionForEvent(fn(string $eventName) => "transaction has been {$eventName}")
            ->useLogName('Crud on Transaction');

    }
}
