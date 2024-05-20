<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Questionnaire extends Model
{
    use HasFactory, SoftDeletes;

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
