<?php
session_start();

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../src/Favorise.php";

$database = new Database();
$pdo = $database->getConnection();

if($_SERVER['REQUEST_METHOD']==='POST'){
    $id=$_POST['rental_id'];

    $favoris=new Favorie($pdo);
    if($supprime=$favoris->annelerFavorise($id)){
    header('Location: favoris.php');
    }
}

?>