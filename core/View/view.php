<?php

namespace app\core\View;

use app\core\View\Template\Template;


class View
{
    public function render($view, $params)
    { 
        
        $temp = new Template();
        
        print( $temp::rendering($view));
        
    }
}
