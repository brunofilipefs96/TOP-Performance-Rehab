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
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'free_training_user')->withTimestamps();
    }
}
