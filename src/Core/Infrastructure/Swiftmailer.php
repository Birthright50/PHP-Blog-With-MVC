<?php

class Swiftmailer
{
    private $from;
    private $transport;

    /**
     * Swiftmailer constructor.
     */
    public function __construct()
    {
        $this->from = "405pervashi@mail.ru";
        $this->transport = (new Swift_SmtpTransport("smtp.mail.ru", 465, "ssl"))
            ->setUsername($this->from)
            ->setPassword("qwerty405");
    }

    public function sendMessage($from, $body): void
    {
        $message = (new Swift_Message("Feedback from ".$from))
            ->setFrom($this->from, "Feedback")
            ->setTo([$this->from => "ADMIN test.com"])
            ->setBody($body);
        $mailer = new Swift_Mailer($this->transport);
        $mailer->send($message);
    }
}