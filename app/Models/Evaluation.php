<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'membership_id',
        'weight',
        'height',
        'waist',
        'hip',
        'chest',
        'arm',
        'forearm',
        'thigh',
        'calf',
        'abdominal_fat',
        'visceral_fat',
        'muscle_mass',
        'fat_mass',
        'hydration',
        'bone_mass',
        'bmr',
        'metabolic_age',
        'physical_evaluation',
        'fat_percentage',
        'imc',
        'ideal_weight',
        'ideal_fat_percentage',
        'ideal_muscle_mass',
        'observations',
        'date',
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

}
