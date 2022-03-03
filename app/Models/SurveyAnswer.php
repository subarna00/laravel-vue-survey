<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;
    use HasFactory;
    protected $fillable = ['survey_id', 'start_date', 'end_date'];
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
    public function surveyAnswerQuestion()
    {
        return $this->hasMany(SurveyQuestionAnswer::class);
    }
}
