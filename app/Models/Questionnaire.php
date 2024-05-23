<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Questionnaire extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
    ];
    public function memberships()
    {
        return $this->belongsToMany(Membership::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
