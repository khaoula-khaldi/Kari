<?php 
require_once __DIR__."/../config/config.php";
require_once __DIR__."/../src/User.php";

session_start();

// créer PDO
$database = new Database();
$pdo = $database->getConnection();


if($_SERVER['REQUEST_METHOD']==='POST'){
    $reservation_id=$_POST['reservation_id'];
    User::cancel($reservation_id);
}

?>