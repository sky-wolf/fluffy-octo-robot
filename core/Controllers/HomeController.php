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

        $Validation = $this->validate([
            'email-1-1' => 'email()',
            'name1-1' => 'alpha',
            'date1-1' => 'date()',
            'ort1-1' => 'alpha',
            'grupp1-1' => 'alpha',
            'email-1-2' => 'email()',
            'name1-2' => 'alpha',
            'date1-2' => 'date()',
            'ort1-2' => 'alpha',
            'grupp1-2' => 'alpha']);
        /* $Validation = $this->validate(/* , AuthForm::signup() ); */
        echo 'Hanterar sickad data';//$this->view("contact");

    }
    
}