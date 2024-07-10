<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymClosure extends Model
{
    use HasFactory;

    protected $fillable = ['closure_date'];
}
