<?php

namespace Illuminate\Foundation\Auth;
use Auth;

trait RedirectsUsers
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (Auth::user()->role == 'trainer') {
            return '/users/myclients';
        }
        
        return '/user/'.Auth::user()->id.'/welcome';
    }
}
