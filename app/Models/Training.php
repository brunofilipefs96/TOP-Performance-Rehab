<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use HasFactory, SoftDeletes;

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function trainingType()
    {
        return $this->belongsTo(TrainingType::class);
    }

    public function users() //Clients (Can be Employees also)
    {
        return $this->hasMany(User::class);
    }

    public function personalTrainer()
    {
        return $this->belongsTo(User::class, 'personal_trainer_id');
    }
}
