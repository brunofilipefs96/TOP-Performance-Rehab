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
        'price',
        'training_type_id',
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

    public function trainingType()
    {
        return $this->belongsTo(TrainingType::class);
    }
}
