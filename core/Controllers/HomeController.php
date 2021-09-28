<?php

namespace app\core\Controllers;
use app\core\Request;
use app\core\Session\Session;
use app\core\Application;

class HomeController extends Controller
{

    public Session $session;

    public function __construct() 
    {
        $this->session = Application::$app->session;    
    }

    public function index()
    {
        return $this->view("home");
    }

    public function contact()
    {
        return $this->view("contact");
    }

    public function postcontact()
    { 

        /* echo '<pre>';
        var_dump($_SERVER);
        echo '</pre>'; */
/*["HTTP_REFERER"]=>
  string(29) "http://localhost:8101/contact"
  ["REQUEST_URI"]=>
  string(8) "/contact"
           $data = validate($_POST, [
            'name' => ,
            'email' => ['required', 'email'],
            'password' => ['required', 'min:10'],
        ]); */
        $Validation = $this->validate([
            'email' => ['required','email'],
            'password' => [ 'required','min:15']
        ]);
        
        echo 'Hanterar sickad data';

    }
    
}