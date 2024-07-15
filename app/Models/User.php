<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        return $this->belongsToMany(Training::class)->withPivot('presence')->withTimestamps();
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
}
