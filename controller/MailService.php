<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// On inclut les fichiers de la bibliothèque que tu as mis dans public/libs
require_once __DIR__ . '/../public/libs/PHPMailer/Exception.php';
require_once __DIR__ . '/../public/libs/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../public/libs/PHPMailer/SMTP.php';

class MailService {
    public static function sendNotification($toEmail, $subject, $messageBody) {
        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur Mailtrap (basée sur ta capture d'écran)
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'e16f6a5d941d26'; // Ton Username
            $mail->Password   = '1d5058e4fd1974'; // mot de passe
            $mail->Port       = 2525;

            // Destinataires
            $mail->setFrom('admin@goorgoorlou.sn', 'Goorgoorlou Admin');
            $mail->addAddress($toEmail);

            // Contenu du mail
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = "
                <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #eee;'>
                    <h2 style='color: #ff5b57;'>Notification de modération</h2>
                    <p>Bonjour,</p>
                    <p>$messageBody</p>
                    <p>L'équipe Goorgoorlou.</p>
                </div>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Erreur Mailer : " . $mail->ErrorInfo);
            return false;
        }
    }
}