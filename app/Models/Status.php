<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function membership()
    {
        return $this->hasOne(Membership::class);
    }

    public function insurance()
    {
        return $this->hasOne(Insurance::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
