<?php

namespace Framework\View;

use Framework\View\Template\Template;


class View
{
    public function render($view, $params)
    { 
        
        $temp = new Template();
        
        print( $temp::rendering($view));
        
    }
}
