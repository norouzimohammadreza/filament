<?php

namespace App\Models;

use App\ActivityLogsFunctions\ActivityLogHelper;
use App\ActivityLogsFunctions\Traits\CheckLogEnabledTrait;
use App\ActivityLogsFunctions\Traits\LogOfSpecificallyModel;
use App\Enums\LogLevelEnum;
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
        LogsActivity, CausesActivity, CheckLogEnabledTrait, LogOfSpecificallyModel;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->logLevel = ModelLog::where('model_type', self::class)->first()->logging_level;
        $this->enableLoggingModelsEvents = ModelLog::where('model_type', self::class)->first()->is_enabled;
    }
    public function tapActivity(Activity $activity, string $eventName,int $level = LogLevelEnum::LOW->value)
    {
        switch ($eventName) {
            case 'created' : $level = LogLevelEnum::MEDIUM->value; break;
            case 'updated' : $level = LogLevelEnum::HIGH->value;break;
            case 'deleted' : $level = LogLevelEnum::CRITICAL->value;break;
        }
        $this->checkIfLoggingIsEnabled();
        if(ActivityLogHelper::$LOGGING_ENABLED)
        {
            if ($this->enableLoggingModelsEvents
                && $level >= $this->logLevel ){
                activity()->enableLogging();
                $activity->level = $level;
            }
        }
        else{
            activity()->disableLogging();
        }
        $activity->ip = inet_pton(request()->ip());
        $activity->url = request()->getPathInfo();
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
    public function log()
    {
        return $this->morphToMany(LoggingInfo::class, 'model');
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
