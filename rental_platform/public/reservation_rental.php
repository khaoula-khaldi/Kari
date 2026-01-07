<?php
session_start();
require_once __DIR__."/../config/config.php";
require_once __DIR__ . '/../src/rental.php';
require_once __DIR__ . '/../src/Booking.php';


if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user_id = $_SESSION['user_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $rental_id = $_POST['rental_id'];
    if(!empty($start_date)||!empty($end_date)){

        try{
                $today=new DateTime(date('Y-m-d'));
                $start=new DateTime($start_date);
                $end=new DateTime($end_date);

                if($start<=$today || $end <= $start){
                    header('Location: erreur_date.php');
                    exit;
                }else{


                $bookingObj = new Booking($pdo);
                $is_available = $bookingObj->checkAvailability($rental_id, $start_date, $end_date);

                if($is_available === 0){
                    if($bookingObj->create($user_id, $rental_id, $start_date, $end_date)){
                        header('Location: allRental.php');
                        exit;
                    } 
                } else {
            
                header('Location: prbReservation.php');
                exit;
                }
            }

        }catch(Exception $e){
                    $message = "Format de date invalide." . $e->getMessage();
                    echo $message;

                } 
            }
    }


?>




