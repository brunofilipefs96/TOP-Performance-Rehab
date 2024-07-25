<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'max_capacity',
        'has_personal_trainer',
        'is_electrostimulation',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($trainingType) {
            if ($trainingType->isForceDeleting()) {
                foreach ($trainingType->trainings as $training) {
                    $training->users()->detach();
                    $training->forceDelete();
                }

                foreach ($trainingType->freeTrainings as $freeTraining) {
                    $freeTraining->users()->detach();
                    $freeTraining->forceDelete();
                }

                foreach ($trainingType->packs as $pack) {
                    foreach ($pack->memberships as $membership) {
                        foreach($membership->user as $user){
                            $user->membership->packs()->detach($pack->id);
                        }
                    }
                    $pack->forceDelete();
                }

            } else {
                foreach ($trainingType->trainings as $training) {
                    $training->users()->detach();
                    $training->delete();
                }

                foreach ($trainingType->freeTrainings as $freeTraining) {
                    $freeTraining->users()->detach();
                    $freeTraining->delete();
                }

                foreach ($trainingType->packs as $pack) {
                    foreach ($pack->memberships as $membership) {
                        foreach($membership->user as $user){
                            $user->membership->packs()->detach($pack->id);
                        }
                    }
                    $pack->delete();
                }
            }
        });

        static::restoring(function ($trainingType) {
            $trainingType->trainings()->withTrashed()->restore();
            $trainingType->freeTrainings()->withTrashed()->restore();
            $trainingType->packs()->withTrashed()->restore();
        });
    }

    public function trainings()
    {
        return $this->hasMany(Training::class);
    }

    public function freeTrainings()
    {
        return $this->hasMany(FreeTraining::class);
    }

    public function memberships()
    {
        return $this->belongsToMany(Membership::class);
    }

    public function packs()
    {
        return $this->hasMany(Pack::class);
    }
}
