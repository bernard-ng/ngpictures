<?php
namespace Ng\Core\Managers\Mailer;

use \RuntimeException;
use Ngpictures\Ngpictures;
use Ng\Core\Managers\ConfigManager;

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
        $this->headers = "MIME-Version: 1.0".'\n';
        $this->headers .= 'From: "Ngpictures" <ngpictures@larytech.com>'.'\n';
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
    public function accountConfirmation(string $link, string $email)
    {

        $confirmation_link = $link;
        $message = require  CORE."/Managers/Mailer/templates/confirmation-mail-template.php";
        mail($email, "Confirmation de compte - Ngpictures", $message, $this->headers);
    }


    /**
     * envoi un mail de mot de passe oublié a un utilisateur
     * variable reset_link est echo dans le fichier template.
     * ne donc pas la retirer
     * @param $link
     * @param $email
     */
    public function resetPassword(string $link, string $email)
    {
        $reset_link = $link;
        $message = require CORE."/Managers/Mailer/templates/reset-mail-template.php";
        mail($email, "Mot de passe oublié - Ngpictures", $message, $this->headers);
    }


    /**
     * envoyer les logs par mail a l'admin
     *
     * @param string $email
     * @return void
     */
    public function sendLogs(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = require ROOT."/system-logs";
            mail($email, $message, $this->headers);
        } else {
            throw new RuntimeException("email invalide");
        }
    }
}
