<?php
namespace Kinnekulle\Mail;
use Kinnekulle\Mail\Message;
use Psr\Http\Message\ResponseInterface as Response;

class Mailer
{
    protected $view;
    protected $mailer;

    public function __construct($view, $mailer)
    {
        $this->view = $view;
        $this->mailer = $mailer;
    }

    public function send($template, $data, $callback)
    {
        $massage = new Message($this->mailer);
        $massage->body($this->view->fetch($template, $data));
        call_user_func($callback, $massage);
        $this->mailer->send();
    }
}