<?php
session_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/rental.php';

$database = new Database();
$pdo = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rental_id'])) {

    $rental_id =$_POST['rental_id']; 

    
    $rental = new Rental($pdo, $_SESSION['user_id'], "", "", "", "", 0.0, 0, "", "");
    

    if ($rental->activateRental($rental_id)) {
        header('Location: rentalAdmin.php');
        exit;
    } else {
        echo "Erreur lors de la suppression";
    }
   
}