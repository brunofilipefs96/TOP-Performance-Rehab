<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'address_id',
        'status_id',
        'monthly_plan',
        'total_trainings_supervised',
        'total_trainings_individual',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function packs()
    {
        return $this->belongsToMany(Pack::class)
            ->withPivot('quantity', 'quantity_remaining', 'expiry_date');
    }

    public function insurance()
    {
        return $this->hasOne(Insurance::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function trainingTypes()
    {
        return $this->belongsToMany(TrainingType::class);
    }

}
