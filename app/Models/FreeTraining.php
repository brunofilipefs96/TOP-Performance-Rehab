<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FreeTraining extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'max_students',
        'start_date',
        'end_date',
        'training_type_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('presence');
    }

    public function trainingType()
    {
        return $this->belongsTo(TrainingType::class);
    }
}
