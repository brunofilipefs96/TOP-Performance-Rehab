<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'file_path'];

    public function sales()
    {
        return $this->belongsToMany(Sale::class);
    }

    public function memberships()
    {
        return $this->belongsToMany(Membership::class);
    }

    public function insurances()
    {
        return $this->belongsToMany(Insurance::class);
    }

    public function evaluations()
    {
        return $this->belongsToMany(Evaluation::class);
    }
}
