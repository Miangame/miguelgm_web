<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 18/05/19
 * Time: 11:35
 */

namespace AppBundle\Services;


class EmailHelper
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($subject, $from, $to, $comments)
    {
        $email = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($comments, 'text/html');

        return $this->mailer->send($email);
    }
}