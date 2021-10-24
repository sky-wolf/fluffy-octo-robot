<?php

namespace Framework\controllers;

use Framework\Validation\Validator;
use Framework\View\View;
use Framework\Response;
use Framework\Request;
use Framework\Application;

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