<?php

namespace App\Models;

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
    use HasFactory, Notifiable, SoftDeletes, HasRoles, HasPanelShield;

    use  HasFactory, SoftDeletes;
    use CausesActivity, LogsActivity, MyLogActivityTrait {
        MyLogActivityTrait::shouldLogEvent insteadof LogsActivity;
    }

    public function __construct(array $attributes = [])
    {
        if ($this->getModelLogSetting()){
        parent::__construct($attributes);
        $modelLoggingSettings = $this->getModelLogSetting();
        $this->logLevel = $modelLoggingSettings->logging_level;
        $this->enableLoggingModelsEvents = $modelLoggingSettings->is_enabled;
    }}

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
