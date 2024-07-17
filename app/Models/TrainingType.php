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
        'has_personal_trainer'
    ];

    public function trainings()
    {
        return $this->hasMany(Training::class);
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
