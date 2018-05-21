<?php
namespace Ng\Core\Managers\Mailer;

use \InvalidArgumentException;
use Ngpictures\Ngpictures;
use PHPMailer\PHPMailer\PHPMailer;
use Ng\Core\Managers\ConfigManager;

class Mailer
{

    /**
     * envoi un mail de confirmation a un utilisateur
     * la variable confirmation_link est echo dans le fichier
     * template, ne donc pas la retirer
     * @param $link
     * @param $email
     * @throws Exception if message could be sent
     * @throws InvalidArgumentException if email is invalid
     */
    public function accountConfirmation(string $link, string $email)
    {
        $mail = new PHPMailer(true);
        $confirmation_link = $link;

        ob_start();
            require CORE."/Managers/Mailer/templates/confirmation-mail-template.php";
        $message = ob_get_clean();

        try {
            $mail->setFrom('ngpictures@larytech.com', 'Ngpictures');
            $mail->addAddress($email);
            $mail->addReplyTo('ngpictures@larytech.com', 'Information');
            $mail->isHTML(true);
            $mail->Subject = 'Bienvenue Sur Ngpictures';
            $mail->Body    =  $message;
            $mail->AltBody = "Cliquez pour confirmer votre compte: {$link}";
            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
        }
    }


    /**
     * envoi un mail de mot de passe oublié a un utilisateur
     * variable reset_link est echo dans le fichier template.
     * ne donc pas la retirer
     * @param $link
     * @param $email
     * @throws Exception if message could be sent
     * @throws InvalidArgumentException if email is invalid
     */
    public function resetPassword(string $link, string $email)
    {
        $mail = new PHPMailer(true);
        $reset_link = $link;

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            ob_start();
                require CORE."/Managers/Mailer/templates/reset-mail-template.php";
            $message = ob_get_clean();

            try {
                $mail->setFrom('ngpictures@larytech.com', 'Ngpictures');
                $mail->addAddress($email);
                $mail->addReplyTo('ngpictures@larytech.com', 'Information');

                $mail->isHTML(true);
                $mail->Subject = 'Instruction de récuperation de mot de passe';
                $mail->Body    =  $message;
                $mail->AltBody = "Cliquez pour récupérer votre mot de passe: {$link}";

                $mail->send();
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
            }
        } else {
            throw new InvalidArgumentException("email invalide");
        }
    }


    /**
     * envoyer les logs par mail a l'admin
     *
     * @param string $email
     * @throws Exception if message could be sent
     * @throws InvalidArgumentException if email is invalid
     * @return void
     */
    public function sendLogs(string $email)
    {
        $mail = new PHPMailer();

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                $mail->setFrom('ngpictures@larytech.com', 'Ngpictures');
                $mail->addAddress($email);
                $mail->addReplyTo('ngpictures@larytech.com', 'Information');

                $mail->isHTML(true);
                $mail->Subject = 'Ngpictures System Logs';
                $mail->Body    =  "Voici le fichier log de ngpictures du ". date("d m Y");
                $mail->AltBody  =   "Voici le fichier log de ngpictures du ". date("d m Y");

                $mail->addAttachment(ROOT."/system.log");
                $mail->send();
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
            }
        } else {
            throw new InvalidArgumentException("email invalide");
        }
    }


    /**
     * formulaire de contact
     *
     * @param string $name
     * @param string $email
     * @param string $message
     * @throws Exception if message could be sent
     * @throws InvalidArgumentException if email is invalid
     * @return void
     */
    public function contact(string $name, string $email, string $message)
    {
        if (fliter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mail = PHPMailer();

            try {
                $mail->setFrom($email, $name);
                $mail->addAddress($email);
                $mail->addReplyTo($email, $name);
                $mail->isHTML(false);
                $mail->Subject = 'Contact';
                $mail->Body    =  $message;
                $mail->AltBody =  $message;
                $mail->send();
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
            }
        } else {
            throw new InvalidArgumentException("email invalide");
        }
    }
}
