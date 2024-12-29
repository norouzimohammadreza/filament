<?php

namespace App\Models;

use App\ActivityLogsFunctions\Traits\CheckLogEnabledTrait;
use App\ActivityLogsFunctions\Traits\LogOfSpecificallyModel;
use App\ActivityLogsFunctions\Traits\MyLogActivityTrait;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles, HasPanelShield,
        LogsActivity, CausesActivity, CheckLogEnabledTrait, LogOfSpecificallyModel, MyLogActivityTrait;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->logLevel = ModelLogSetting::where('model_type', self::class)->first()->logging_level;
        $this->enableLoggingModelsEvents = ModelLogSetting::where('model_type', self::class)->first()->is_enabled;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function modelRecordLogSettings()
    {
        return $this->morphOne(ModelRecordLogSetting::class, 'model');
    }

    public function posts()
    {
        $this->hasMany(Post::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty();
    }

    public function logs()
    {
        return $this->hasMany(Activity::class, 'causer_id');
    }
}
