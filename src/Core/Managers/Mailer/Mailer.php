<?php
namespace Ng\Core\Managers\Mailer;

use Ngpictures\Ngpictures;
use \InvalidArgumentException;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Ng\Core\Managers\ConfigManager;
use Ng\Core\Managers\LogMessageManager;

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
        require CORE . "/Managers/Mailer/templates/confirmation-mail-template.php";
        $message = ob_get_clean();

        try {
            $mail->smtpConnect();
            $mail->setFrom('ngpictures@larytech.com', 'Ngpictures');
            $mail->addAddress($email);
            $mail->addReplyTo('ngpictures@larytech.com', 'Information');
            $mail->isHTML(true);
            $mail->Subject = 'Bienvenue Sur Ngpictures';
            $mail->Body = $message;
            $mail->AltBody = "Cliquez pour confirmer votre compte: {$link}";
            $mail->send();
        } catch (Exception $e) {
            LogMessageManager::register(__class__, $e);
            return false;
        }
    }


    public function photographerConfirmation(string $email)
    {
        $mail = new PHPMailer(true);

        ob_start();
        require CORE . "/Managers/Mailer/templates/photographer-mail-template.php";
        $message = ob_get_clean();

        try {
            $mail->smtpConnect();
            $mail->setFrom('ngpictures@larytech.com', 'Ngpictures');
            $mail->addAddress($email);
            $mail->addReplyTo('ngpictures@larytech.com', 'Information');
            $mail->isHTML(true);
            $mail->Subject = 'Félicitation Cher Photographe';
            $mail->Body = $message;
            $mail->AltBody = "Félicitation vous venez tout juste de créer un compte photographe sur Ngpictures.";
            $mail->send();
        } catch (Exception $e) {
            LogMessageManager::register(__class__, $e);
            return false;
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
            require CORE . "/Managers/Mailer/templates/reset-mail-template.php";
            $message = ob_get_clean();

            try {
                $mail->smtpConnect();
                $mail->setFrom('ngpictures@larytech.com', 'Ngpictures');
                $mail->addAddress($email);
                $mail->addReplyTo('ngpictures@larytech.com', 'Information');

                $mail->isHTML(true);
                $mail->Subject = 'Instruction de récuperation de mot de passe';
                $mail->Body = $message;
                $mail->AltBody = "Cliquez pour récupérer votre mot de passe: {$link}";

                $mail->send();
            } catch (Exception $e) {
                LogMessageManager::register(__class__, 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
                return false;
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
                $mail->Body = "Voici le fichier log de ngpictures du " . date("d m Y");
                $mail->AltBody = "Voici le fichier log de ngpictures du " . date("d m Y");

                $mail->addAttachment(ROOT . "/system.log");
                $mail->send();
            } catch (Exception $e) {
                LogMessageManager::register(__class__, $e);
                return false;
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
     * @throws Exception if message couldn't be sent
     * @throws InvalidArgumentException if email is invalid
     * @return void
     */
    public function contact(string $name, string $email, string $message)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mail = new PHPMailer(true);

            try {
                $mail->setFrom($email, $name);
                $mail->addAddress($email);
                $mail->addReplyTo($email, $name);
                $mail->isHTML(false);
                $mail->Subject = 'Contact';
                $mail->Body = $message;
                $mail->AltBody = $message;
                $mail->send();
            } catch (Exception $e) {
                LogMessageManager::register(__class__, 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
                return false;
            }
        } else {
            throw new InvalidArgumentException("email invalide");
        }
    }


    /**
     * notification de reservation
     *
     * @param string $photographer_email
     * @param string $name
     * @param string $email
     * @param string $date
     * @param string $time
     * @param string $description
     * @return void
     */
    public function booking(string $photographer_email, string $name, string $email, string $date, string $time, string $description)
    {
        $mail = new PHPMailer(true);
        ob_start();
        require CORE . "/Managers/Mailer/templates/booking-mail-template.php";
        $message = ob_get_clean();

        try {
            $mail->smtpConnect();
            $mail->setFrom('ngpictures@larytech.com', 'Ngpictures');
            $mail->addAddress($email);
            $mail->addReplyTo($email, $name);
            $mail->isHTML(true);
            $mail->Subject = 'Réservation shooting';
            $mail->Body = $message;
            $mail->AltBody = "Monsieur/Madame : {$name}, réserve un shoot pour le {$date} à {$time} \n Motif: {$description}";
            $mail->send();
        } catch (Exception $e) {
            LogMessageManager::register(__class__, $e);
            return false;
        }
    }
}
