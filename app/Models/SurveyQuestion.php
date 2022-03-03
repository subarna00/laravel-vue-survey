<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SurveyQuestionAnswer;

class SurveyQuestion extends Model
{
    use HasFactory;
    protected $fillable = ['question', 'data', 'type', 'survey_id', 'description'];
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
    public function surveyAnswerQuestion()
    {
        return $this->hasMany(SurveyQuestionAnswer::class);
    }
}
