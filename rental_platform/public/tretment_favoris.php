<?php
session_start();

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../src/Favorise.php";

$database = new Database();
$pdo = $database->getConnection();

if($_SERVER['REQUEST_METHOD']==='POST'){
    $rental_id=$_POST['rental_id'];
    $user_id=$_POST['user_id'];

    $favoris=new Favorie($pdo);
    $ajoute=$favoris->add($user_id,$rental_id);
    header('Location: allRental.php');

    // $supprime=$favoris->remouve($user_id,$rental_id); 
    
     
    

}

?>