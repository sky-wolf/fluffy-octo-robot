<?php
namespace Framework\routes;
use Framework\Application;
use Framework\Request;
use Framework\Response;
use Framework\http;
use Framework\controllers;

class Router
{
    protected array $routes = [];
    protected $namespace = "Framework\Controllers\\";
    public Request $request;
    public Response $response;

    public function __construct(Request $requests,Response $responses)
    {
        $this->request = $requests;
        $this->response = $responses;

        require_once 'web.php';

    }

    public function resolve()
    {   
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        
        if($callback === false)
        {
            $this->response->setStatusCode(404);
            return '404';
            exit;
        }

        $this->request->getBody();

        if( is_string($callback))
        {
            return $this->renderView($callback);
        }
        
        if(is_array($callback))
        {
            $callback[0] = $this->namespace . $callback[0];
            $callback[0] = new $callback[0];
            $parameters = [];
            $controller = $callback[0];
            $controller->callAction($callback[1], $parameters, $this->request, $this->response );
            
        }
        /* echo '<pre>';
        var_dump($callback);
        echo '</pre>';
        exit; */
    }

    public function get(string $path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function renderView($view)
    {
        include_once Application::$ROOT_DIR."/resources/views/$view.php";
    }
}