<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'capacity',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function trainings()
    {
        return $this->hasMany(Training::class);
    }
}
