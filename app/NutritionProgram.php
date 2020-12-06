<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NutritionProgram extends Model
{
    
    protected $table = 'nutritionPrograms';
    
    protected $fillable = [
        'date',
        'target_calories',
        'water_intake',
        'meals',
        'program_notes',
        'owner_id',
    ];
    
    public function session()
    {
        return $this->belongsTo('App\TrainingSession');
    }
}
