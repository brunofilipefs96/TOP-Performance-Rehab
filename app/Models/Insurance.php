<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insurance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'membership_id',
        'status_id',
        'insurance_type',
        'start_date',
        'end_date',
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
