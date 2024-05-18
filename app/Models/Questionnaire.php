<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
