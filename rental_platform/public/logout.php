<?php

session_start(); // khass start session bach naccessiw $_SESSION

// Supprimer tous les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// Rediriger l'utilisateur vers la page de login
header('Location: login.php');
exit;
?>
