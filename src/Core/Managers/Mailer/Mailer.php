<?php
namespace Ng\Core\Managers\Mailer;

use InvalidArgumentException;
use Ng\Core\Managers\LogMessageManager;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class Mailer
 * @package Ng\Core\Managers\Mailer
 */
class Mailer
{

    /**
     * @param string $link
     * @param string $email
     * @return bool
     */
    public function accountConfirmation(string $link, string $email)
    {
        $mail = new PHPMailer(true);
        $confirmation_link = $link;

        ob_start();
        require CORE . "/Managers/Mailer/templates/confirmation-mail-template.php";
        $message = ob_get_clean();

        try {
            $this->setUpSMTP($mail);
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

    /**
     * @param PHPMailer $mail
     */
    private function setUpSMTP(PHPMailer $mail)
    {
        $mail->isSMTP();
        $mail->Host = 'mail.larytech.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ngpictures@larytech.com';
        $mail->Password = ']3dneN!%2@y,';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
    }

    public function photographerConfirmation(string $email)
    {
        $mail = new PHPMailer(true);

        ob_start();
        require CORE . "/Managers/Mailer/templates/photographer-mail-template.php";
        $message = ob_get_clean();

        try {
            $this->setUpSMTP($mail);

            $mail->setFrom('ngpictures@larytech.com', 'Ngpictures');
            $mail->addAddress($email);
            $mail->addReplyTo('ngpictures@larytech.com', 'Information');
            $mail->isHTML(true);
            $mail->Subject = 'Welcome Photographer';
            $mail->Body = $message;
            $mail->AltBody = "Félicitation vous venez tout juste de créer un compte photographe sur Ngpictures.";
            $mail->send();
        } catch (Exception $e) {
            LogMessageManager::register(__class__, $e);
            return false;
        }
    }

    /**
     * @param string $link
     * @param string $email
     * @return bool
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
                $this->setUpSMTP($mail);

                $mail->setFrom('ngpictures@larytech.com', 'Ngpictures');
                $mail->addAddress($email);
                $mail->addReplyTo('ngpictures@larytech.com', 'Information');

                $mail->isHTML(true);
                $mail->Subject = 'Instruction pour mot de passe';
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
     * @param string $email
     * @return bool
     */
    public function sendLogs(string $email)
    {
        $mail = new PHPMailer();

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                $this->setUpSMTP($mail);

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
     * @param string $name
     * @param string $email
     * @param string $message
     * @return bool
     */
    public function contact(string $name, string $email, string $message)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mail = new PHPMailer(true);

            try {
                $this->setUpSMTP($mail);

                $mail->setFrom('ngpictures@larytech.com', 'Ngpictures');
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
     * @param string $photographer_email
     * @param string $name
     * @param string $email
     * @param string $date
     * @param string $time
     * @param string $description
     * @return bool
     */
    public function booking(string $photographer_email, string $name, string $email, string $date, string $time, string $description)
    {
        $mail = new PHPMailer(true);
        ob_start();
        require CORE . "/Managers/Mailer/templates/booking-mail-template.php";
        $message = ob_get_clean();

        try {
            $this->setUpSMTP($mail);

            $mail->setFrom('ngpictures@larytech.com', 'Ngpictures');
            $mail->addAddress($email);
            $mail->addReplyTo($email, $name);
            $mail->isHTML(true);
            $mail->Subject = 'Booking shooting';
            $mail->Body = $message;
            $mail->AltBody = "Monsieur/Madame : {$name}, réserve un shoot pour le {$date} à {$time} \n Motif: {$description}";
            $mail->send();
        } catch (Exception $e) {
            LogMessageManager::register(__class__, $e);
            return false;
        }
    }
}
