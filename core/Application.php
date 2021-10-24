<?php
namespace Framework;
use Framework\routes\Router;
//use Framework\Database\Database;

use Framework\Session\Session;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    //public Database $db;
    public Session $session;
    public static Application $app;
    


    public function __construct($rootpath)
    {
        self::$app = $this;
        self::$ROOT_DIR = $rootpath;
        $this->request = new Request();
        //$this->db = new Database();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request,$this->response);
    }

    public function Run()
    {
       $this->router->resolve();
    }
}