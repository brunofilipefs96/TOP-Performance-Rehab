<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function trainingType()
    {
        return $this->belongsTo(TrainingType::class);
    }

    public function users() // Clientes
    {
        return $this->hasMany(User::class);
    }

    public function personalTrainer() // Personal Trainer
    {
        return $this->belongsTo(User::class);
    }
}
