<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pack extends Model
{
    use HasFactory, SoftDeletes;

    public function memberships()
    {
        return $this->belongsToMany(Membership::class);
    }

    protected $fillable = [
        'name',
        'price',
        'trainings_number',
        'has_personal_trainer',
    ];
}
