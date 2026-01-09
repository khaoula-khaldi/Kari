<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/../../vendor/autoload.php';


class Mailer {
    private static function getMailer(): PHPMailer{
      

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   ='khaoula2417@gmail.com';
        $mail->Password   = 'uwfe xdif nsym ohxq';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('khaoula2417@gmail.com', 'kari ');
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        return $mail;
    }

    public static function send(
        string $to,
        string $subject,
        string $body
    ): bool {
        try {
            $mail = self::getMailer();
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            return $mail->send();
        } catch (Exception $e) {
            error_log("Email error: " . $e->getMessage());
            return false;
        }
    }
    public static function sendBookingConfirmation(string $emailHote,int $logementId): void {
            $subject = "New reservation";
            $body = "<h3>New reservation</h3>
                <p>A new reservation has been made for your logement. <strong>#{$logementId}</strong>.</p>";

            Mailer::send($emailHote, $subject, $body);
    }


    // public function sendBookingConfirmation($userEmail, $userName, $rentalTitle) {
    //     try {
    //         $this->mail->clearAddresses();
    //         $this->mail->addAddress($userEmail, $userName);
    //         $this->mail->Subject = "Confirmation de réservation";
    //         $this->mail->Body    = "Bonjour {$userName},<br>Votre réservation pour <strong>{$rentalTitle}</strong> est confirmée !";
    //         return $this->mail->send();
    //     } catch (Exception $e) {
    //         error_log("Erreur email confirmation: ".$e->getMessage());
    //         return false;
    //     }
    // }

    // public function sendBookingCancellation($userEmail, $userName, $rentalTitle) {
    //     try {
    //         $this->mail->clearAddresses();
    //         $this->mail->addAddress($userEmail, $userName);
    //         $this->mail->Subject = "Annulation de réservation";
    //         $this->mail->Body    = "Bonjour {$userName},<br>Votre réservation pour <strong>{$rentalTitle}</strong> a été annulée.";
    //         return $this->mail->send();
    //     } catch (Exception $e) {
    //         error_log("Erreur email annulation: ".$e->getMessage());
    //         return false;
    //     }
    // }
}
?>

<!-- 
require_once __DIR__ . "/../src/Mailer.php";

$mailer = new Mailer();

// Notification pour le voyageur
$mailer->sendBookingConfirmation($travelerEmail, $travelerName, $rentalTitle);

// Notification pour l’hôte
$mailer->sendBookingConfirmation($hostEmail, $hostName, $rentalTitle);

// Pour l’annulation
$mailer->sendBookingCancellation($travelerEmail, $travelerName, $rentalTitle);
$mailer->sendBookingCancellation($hostEmail, $hostName, $rentalTitle); -->





    <!-- public static function sendBookingCancellation(string $emailUser,int $reservationId,string $reason): void {
        $subject = "Reservation cancelled";
        $body = " <h3>Reservation cancelled</h3>
            <p>The reservation <strong>#{$reservationId}</strong> has been cancelled.</p>
            <p>Reason : {$reason}</p>";

        EmailService::send($emailUser, $subject, $body);
    } -->



<?php
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
// use Dotenv\Dotenv;

// require_once DIR . '/../vendor/autoload.php';

// class EmailService
// {
//     private static function getMailer(): PHPMailer
//     {
//         $dotenv = Dotenv::createImmutable(DIR);
//         $dotenv->load();
//         $mail = new PHPMailer(true);

//         $mail->isSMTP();
//         $mail->Host       = 'smtp.gmail.com';
//         $mail->SMTPAuth   = true;
//         $mail->Username   = $_ENV['stmp_username'];
//         $mail->Password   = $_ENV['stmp_password'];
//         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//         $mail->Port       = 587;

//         $mail->setFrom('abdo.el.kabli12@gmail.com', 'kari Clone');
//         $mail->isHTML(true);
//         $mail->CharSet = 'UTF-8';

//         return $mail;
//     }

//     public static function send(
//         string $to,
//         string $subject,
//         string $body
//     ): bool {
//         try {
//             $mail = self::getMailer();
//             $mail->addAddress($to);
//             $mail->Subject = $subject;
//             $mail->Body    = $body;

//             return $mail->send();
//         } catch (Exception $e) {
//             error_log("Email error: " . $e->getMessage());
//             return false;
//         }
//     }
// }