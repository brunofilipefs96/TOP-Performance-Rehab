<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'training_type_id',
        'room_id',
        'name',
        'max_students',
        'start_date',
        'end_date',
        'personal_trainer_id',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function trainingType()
    {
        return $this->belongsTo(TrainingType::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['presence', 'cancelled']);
    }

    public function personalTrainer()
    {
        return $this->belongsTo(User::class, 'personal_trainer_id');
    }

    public function packs()
    {
        return $this->hasMany(Pack::class);
    }
}
