<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use MattDaneshvar\Survey\Models\Entry;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'birth_date',
        'email',
        'phone_number',
        'gender',
        'nif',
        'cc_number',
        'password',
        'image',
        'active_role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            if ($user->isForceDeleting()) {
                if (Schema::hasColumn('trainings', 'personal_trainer_id')) {
                    $user->trainingsAsPersonalTrainer()->forceDelete();
                }
                if (Schema::hasColumn('addresses', 'user_id')) {
                    $user->addresses()->forceDelete();
                }
                if (Schema::hasColumn('services', 'user_id')) {
                    $user->services()->forceDelete();
                }
                if (Schema::hasColumn('sales', 'user_id')) {
                    $user->sales()->forceDelete();
                }
                if (Schema::hasColumn('notification_user', 'user_id')) {
                    $user->notifications()->forceDelete();
                }
                if (Schema::hasColumn('free_training_user', 'user_id')) {
                    $user->freeTrainings()->forceDelete();
                }
                $user->roles()->detach();
                if (Schema::hasColumn('memberships', 'user_id')) {
                    $user->membership()->forceDelete();
                }
                if (Schema::hasColumn('entries', 'participant_id')) {
                    $user->entries()->forceDelete();
                }
                if (Schema::hasTable('training_user')) {
                    $user->trainings()->detach();
                }
            } else {
                if (Schema::hasColumn('trainings', 'personal_trainer_id')) {
                    $user->trainingsAsPersonalTrainer()->delete();
                }
                if (Schema::hasColumn('addresses', 'user_id')) {
                    $user->addresses()->delete();
                }
                if (Schema::hasColumn('services', 'user_id')) {
                    $user->services()->delete();
                }
                if (Schema::hasColumn('sales', 'user_id')) {
                    $user->sales()->delete();
                }
                if (Schema::hasColumn('notification_user', 'user_id')) {
                    $user->notifications()->delete();
                }
                if (Schema::hasColumn('free_training_user', 'user_id')) {
                    $user->freeTrainings()->delete();
                }
                if (Schema::hasColumn('memberships', 'user_id')) {
                    $user->membership()->delete();
                }
                if (Schema::hasColumn('entries', 'participant_id')) {
                    $user->entries()->delete();
                }
                if (Schema::hasTable('training_user')) {
                    $user->trainings()->detach();
                }
            }
        });

        static::restoring(function ($user) {
            if (Schema::hasColumn('trainings', 'personal_trainer_id')) {
                $user->trainingsAsPersonalTrainer()->withTrashed()->restore();
            }
            if (Schema::hasColumn('addresses', 'user_id')) {
                $user->addresses()->withTrashed()->restore();
            }
            if (Schema::hasColumn('services', 'user_id')) {
                $user->services()->withTrashed()->restore();
            }
            if (Schema::hasColumn('sales', 'user_id')) {
                $user->sales()->withTrashed()->restore();
            }
            if (Schema::hasColumn('notification_user', 'user_id')) {
                $user->notifications()->withTrashed()->restore();
            }
            if (Schema::hasColumn('free_training_user', 'user_id')) {
                $user->freeTrainings()->withTrashed()->restore();
            }
            if (Schema::hasColumn('memberships', 'user_id')) {
                $user->membership()->withTrashed()->restore();
            }
            if (Schema::hasColumn('entries', 'participant_id')) {
                $user->entries()->withTrashed()->restore();
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function firstLastName(): string
    {
        $names = explode(' ', $this->full_name);

        if (count($names) == 1) {
            return $names[0];
        } else {
            return $names[0] . ' ' . $names[count($names) - 1];
        }
    }

    public function activeRole()
    {
        return $this->belongsTo(Role::class, 'active_role_id');
    }

    public function assignHighestPriorityRole()
    {
        $roles = $this->roles()->orderBy('priority')->get();
        if ($roles->isNotEmpty()) {
            $this->active_role_id = $roles->first()->id;
            $this->save();
        }
    }

    public function hasRole(string $role): bool
    {
        return $this->activeRole && $this->activeRole->name === $role;
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class)->withPivot(['presence', 'cancelled'])->withTimestamps();
    }

    public function trainingsAsPersonalTrainer()
    {
        return $this->hasMany(Training::class, 'personal_trainer_id');
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_user')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    public function freeTrainings()
    {
        return $this->belongsToMany(FreeTraining::class)->withPivot('presence')->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function membership()
    {
        return $this->hasOne(Membership::class);
    }

    public function entries()
    {
        return $this->hasMany(Entry::class, 'participant_id');
    }

    public function membershipEntry()
    {
        return $this->hasOne(Entry::class, 'participant_id')->where('survey_id', 1)->exists();
    }

    public function clientType()
    {
        return $this->belongsTo(ClientType::class);
    }
}
