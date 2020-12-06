<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'owner_id',
        'phone',
        'addr_line_1',
        'addr_line_2',
        'city',
        'state',
        'zip',
        'ec_name',
        'ec_phone',
        'ec_relationship',
        'med_cond',
        'exer_cond',
        'food_cond',
        'diet_cond',
        'target_bf',
        'target_mg',
        'session_price',
        'calendar',
        'height',
        'has_dashboard',
        'has_nutrition',
        'has_exercise',
        'can_edit',
        'notes',
        'status',
        'gender',
    ];

     /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    /**
     * Get the parent that owns the user.
     */
    public function trainer()
    {
        
        return $this->belongsTo('App\User', 'owner_id');
    }
    
    public function client()
    {
        return $this->hasMany('App\User', 'owner_id')->orderBy('name');
    }
    
    public function sessions()
    {
        return $this->hasMany('App\TrainingSession', 'owner_id');
    }

    public function groups()
    {
        return $this->BelongsToMany('App\Group');
    }
}
