<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NutritionProgramTemplate extends Model
{


    protected $table = 'nutritionTemplate';
    
    protected $fillable = [
        'name',
        'mealtemplate',
        'program_notes',
    ];
}
