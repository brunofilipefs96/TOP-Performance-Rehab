<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'questionnaire_id',
        'question_type_id',
        'question_text',
    ];
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function questionType()
    {
        return $this->belongsTo(QuestionType::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
