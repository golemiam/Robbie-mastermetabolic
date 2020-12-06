<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    protected $fillable = [
        'date',
        'time',
        'location',
        'weight',
        'body_fat',
        'skyndex_setting',
        'neck',
        'arm',
        'chest',
        'waist',
        'hips',
        'thigh',
        'calf',
        'forearm',
        'owner_id',
        'session_number',
    ];
    
    public function client()
    {
        return $this->belongsTo('App\User');
    }
    
    public function nutritionProgram()
    {
        return $this->hasOne('App\NutritionProgram', 'owner_id');
    }
    
    public function exerciseProgram()
    {
        return $this->hasOne('App\ExerciseProgram', 'owner_id');
    }
}
