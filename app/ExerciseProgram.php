<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExerciseProgram extends Model
{
    protected $table = 'exercisePrograms';
    
    protected $fillable = [
        'date',
        'circuits',
        'program_notes',
        'owner_id',
    ];
    
    public function session()
    {
        return $this->belongsTo('App\TrainingSession');
    }
}
