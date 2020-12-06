<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExerciseProgramTemplate extends Model
{


    protected $table = 'exerciseTemplate';
    
    protected $fillable = [
        'name',
        'circuittemplate',
        'program_notes',
    ];
}
