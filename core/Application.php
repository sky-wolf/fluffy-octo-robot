<?php
namespace Framework;
use Framework\routes\Router;

use Framework\Session\Session;
use Framework\Support\DotEnv;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;

    public Session $session;
    public static Application $app;
    


    public function __construct($rootpath)
    {
        (new DotEnv())->load();
        self::$app = $this;
        self::$ROOT_DIR = $rootpath;
        $this->request = new Request();
 
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request,$this->response);
    }

    public function Run()
    {
        
        $this->router->resolve();
    }
}