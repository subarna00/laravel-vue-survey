<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Survey extends Model
{
    use HasFactory, HasSlug;

    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_SELECT = 'select';
    const TYPE_RADIO = 'radio';
    const TYPE_CHECKBOX = 'checkbox';
    protected $fillable = ['user_id', 'image', 'title', 'status', 'description', 'expire_date', 'client_id', 'employe_id'];

    public function getSlugOptions(): SlugOptions
    {
        return slugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }
    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class);
    }
    public function clients()
    {
        return $this->hasOne(Client::class);
    }
    public function employes()
    {
        return $this->hasOne(Employe::class);
    }
}
