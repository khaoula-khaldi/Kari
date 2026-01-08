<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Vérifier le chemin
$autoloadPath = __DIR__ . '/../vendor/autoload.php';
// Charger PHPMailer via Composer
require_once $autoloadPath;

class Mailer {
    private PHPMailer $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);

        try {
            $this->mail->isSMTP();
            $this->mail->Host       = 'smtp.example.com';
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = 'khaoula2417@gmail.com';
            $this->mail->Password   = 'uwfe xdif nsym ohxq';
            $this->mail->SMTPSecure = 'tls';
            $this->mail->Port       = 587;

            $this->mail->setFrom('khaoula2417@gmail.com', 'Booking Platform');
            $this->mail->isHTML(true);
        } catch (Exception $e) {
            echo "Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

    public function sendBookingConfirmation($userEmail, $userName, $rentalTitle) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($userEmail, $userName);
            $this->mail->Subject = "Confirmation de réservation";
            $this->mail->Body    = "Bonjour {$userName},<br>Votre réservation pour <strong>{$rentalTitle}</strong> est confirmée !";
            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Erreur email confirmation: ".$e->getMessage());
            return false;
        }
    }

    public function sendBookingCancellation($userEmail, $userName, $rentalTitle) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($userEmail, $userName);
            $this->mail->Subject = "Annulation de réservation";
            $this->mail->Body    = "Bonjour {$userName},<br>Votre réservation pour <strong>{$rentalTitle}</strong> a été annulée.";
            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Erreur email annulation: ".$e->getMessage());
            return false;
        }
    }
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
