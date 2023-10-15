<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class EmailSender
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true); // throws exception on failure
    }

    public function send($to, $subject, $body)
    {
        try {
            //Server settings
            $this->mailer->SMTPDebug = 0; //Enable verbose debug output
            $this->mailer->isSMTP(); //Set mailer to use SMTP
            $this->mailer->Host = 'smtp.yandex.ru'; //Specify main and backup SMTP servers
            $this->mailer->SMTPAuth = true; //Enable SMTP authentication
            $this->mailer->Username = 'kuganvlad@yandex.ru'; //SMTP username
            $this->mailer->Password = 'edyojjdpaeopviug'; //SMTP password
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable TLS encryption, `ssl` also accepted
            $this->mailer->Port = 465; //TCP port to connect to

            //Recipients
            $this->mailer->setFrom('kuganvlad@yandex.ru', 'kuganvlad');
            $this->mailer->addAddress($to); //Add a recipient

            //Attachments
//            foreach ($attachments as $attachment) {
//                $this->mailer->addAttachment($attachment);
//            }

            //Content
            $this->mailer->isHTML(true); //Set email format to HTML
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->CharSet = 'UTF-8';

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            echo($e);
            return false;
        }
    }
}