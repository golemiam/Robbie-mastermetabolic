<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nutritions extends Model
{
    protected $fillable = [
        'name',
        'portion_name',
        'category',
        'calories',
        'fats',
        'carbs',
        'proteins',
        'favorite',
    ];
}
