<?php

namespace App\Http\Composers;

use Illuminate\Contracts\View\View;

class MasterComposer
{

    public function compose(View $view)
    {
    
        $theme_color = config('THEME_COLOR', 'blue');
        $theme_title = config('THEME_TITLE', 'Master Metabolic');
        
        $view->with('color', $theme_color);
        $view->with('title', $theme_title);
    }
}
