<?php

namespace Framework;

class Request  
{
    protected $body = [];

    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $pos = strpos($path, '?');

        if ($pos === false) {
            return $path;
        }

        return substr($path, 0, $pos);
    }

    public function getMethod()
    {
        return strtolower( $_SERVER['REQUEST_METHOD'] );
    }
    
    public function isGet()
    {
        return $this->getMethod()=== 'get';
    }
       
    public function isPost()
    {
        return $this->getMethod()=== 'post';
    }
       
    public function getBody()
    {
        /* if($this->isGet())
        {
            foreach($_GET as $key => $value)
            {
                $this->body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }    
        }
 */
        if($this->isPost())
        {
            foreach($_POST as $key => $value)
            {
                $this->body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }    
        }
        /* echo '<pre>';
        var_dump( $this->body);
        echo '</pre>'; */
        return $this->body;
    }

    public function getParam($name)
    {
        # code...
    }
}
