<?php
namespace Ng\Core\Generic\Mailer;

use Ngpictures\Ngpic;


class MailSender
{

    /**
     * les headers pour les mails
     * @var string
     */
    private $headers;


    /**
     * MailSender constructor.
     */
    public function __construct()
    {
        $this->headers = "MIME-Version: 1.0\r\n";
        $this->headers .= 'From: "Ngpictures"<ngpictures@larytech.com>'.'\n';
        $this->headers .= 'Content-Type: text/html; charset="utf-8"'.'\n';
        $this->headers .= 'Content-Transfer-Encoding: 8bit';
    }


    /**
     * envoi un mail de confirmation a un utilisateur
     * la variable confirmation_link est echo dans le fichier
     * template, ne donc pas la retirer
     * @param $link
     * @param $email
     */
    public function accountConfirmation($link,$email)
    {

        $confirmation_link = $link;
        $message = require  CORE."/Generic/Mailer/confirmation-mail-template.php";

        echo $message;
        die();

        mail($email, "Confirmation de compte - Ngpictures", $message, $this->headers);
        Ngpic::redirect("/login");

    }


    /**
     * envoi un mail de mot de passe oublié a un utilisateur
     * variable reset_link est echo dans le fichier template.
     * ne donc pas la retirer
     * @param $link
     * @param $email
     */
    public function resetPassword($link, $email)
    {
        $reset_link = $link;
        $message = require CORE."/Generic/Mailer/reset-mail-template.php";

        echo $message;
        die();

        mail($email, "Mot de passe oublié - Ngpictures", $message, $this->headers);
        Ngpic::redirect("/login");
    }
}