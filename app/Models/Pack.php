<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pack extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'duration',
        'trainings_number',
        'has_personal_trainer',
        'price',
    ];

    public function memberships()
    {
        return $this->belongsToMany(Membership::class)
            ->withPivot('quantity', 'quantity_remaining', 'expiry_date');
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class)
            ->withPivot('quantity', 'price');
    }


}
