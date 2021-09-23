<?php
namespace Kinnekulle\Mail;

class Message
{
    protected $mailer;

    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    public function to($adress)
    {
       $this->mailer->addAddress($adress);
    }

    public function subject($subject)
    {
        $this->mailer->Subject = $subject;
    }

    public function body($body)
    {
        $this->mailer->Body = $body;
    }
}