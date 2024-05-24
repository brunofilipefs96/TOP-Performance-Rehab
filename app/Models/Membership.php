<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use HasFactory, SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function packs()
    {
        return $this->belongsToMany(Pack::class);
    }

    public function insurance()
    {
        return $this->hasOne(Insurance::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

}
