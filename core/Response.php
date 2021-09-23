<?php
namespace app\core;

class Response
{
    Public function setStatusCode(int $cond)
    {
        http_response_code($cond);
    }

    Public function redirect($url)
    {
        header("Location: $url");
    }
}
