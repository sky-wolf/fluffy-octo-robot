<?php

namespace app\core\controllers;

use app\core\Validation\Validator;
use app\core\View\View;
use app\core\Response;
use app\core\Request;
use app\core\Application;

class Controller
{
    public function callAction($method, $parameters, Request $requests, Response $responses)
    {
        return call_user_func( [$this, $method], $parameters,  $requests, $responses);
        return call_user_func_array([$this, $method], $parameters);
    }

    public function view($view, $params = [])
    {
        $v = new view();
        $v->render($view, $params);
    }

    public function validate(array $rules = [])
    {
        $validator = new Validator();
        $Validation = $validator->validate(Application::$app->request, $rules);
        /* echo '<pre>';
            var_dump($request->getBody());
            echo '</pre>'; */
    }
} 