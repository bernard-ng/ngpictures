<?php
namespace Ng\Core\Managers\Mailer;

use Ngpictures\Ngpictures;

class Mailer
{

    /**
     * les headers pour les mails
     * @var string
     */
    private $headers;


    /**
     * Mailer constructor.
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
    public function accountConfirmation($link, $email)
    {

        $confirmation_link = $link;
        $message = require  CORE."/Util/Mailer/templates/confirmation-mail-template.php";

        mail("ngandubernard@gmail.com", "Confirmation de compte - Ngpictures", $message, $this->headers);
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
        $message = require CORE."/Util/Mailer/templates/reset-mail-template.php";

        mail("ngandubernard@gmail.com", "Mot de passe oublié - Ngpictures", $message, $this->headers);
    }


    /* Envoi les logs du site a l'administrateur */
    public function sendLogs($config)
    {
        $email = $config->get('site.email');
        $message = require ROOT."/system-logs";
        mail($email, $message, $this->headers);
    }
}
