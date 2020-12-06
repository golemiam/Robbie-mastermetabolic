<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',
        'desc'
    ];
    
    public function users()
    {
        return $this->BelongsToMany('App\User');
    }
}
