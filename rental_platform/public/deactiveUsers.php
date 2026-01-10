<?php   

    session_start();
    require_once __DIR__ . '/../config/config.php';
    require_once __DIR__ . '/../src/User.php';

    $database = new Database();
    $pdo = $database->getConnection();

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
    
   
if($_SERVER['REQUEST_METHOD']==='POST'){
    $is_active = $_POST['is_active']; 
    $id = $_POST['id'];
    $user = new User($pdo, '', '', '', '');
    $user->Is_Active($is_active, $id);
    header('Location: dashbord.php');
    exit;
}