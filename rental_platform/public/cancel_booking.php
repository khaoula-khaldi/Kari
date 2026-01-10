<?php 
session_start();
$user_id=$_SESSION['user_id'];
require_once __DIR__."/../config/config.php";

require_once __DIR__ . '/../src/User.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $reservation_id=$_POST['reservation_id'];

    $user=new User($pdo, '', '', '', '');

    $user->cancel($reservation_id, $user_id);
    header('Location: profil.php');
    exit;
}
// $user = new User($pdo, '', $email, $password, '');
?>