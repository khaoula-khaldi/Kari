
<?php 
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/rental.php';


if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    die("Accès interdit");
}
    

if($_SERVER['REQUEST_METHOD']==='POST'){
        $id=$_POST['id'];
        $host_id=$_SESSION['user_id'];
        $title=$_POST['title'];
        $description=$_POST['description'];
        $address=$_POST['address'];
        $city=$_POST['city'];
        $price_per_night=$_POST['price_per_night'];
        $capacity=(int)$_POST['capacity'];
        $available_dates=$_POST['available_dates'];

        $imagePath = null;
        if($_FILES['image']['error']===0){
            $uploadDir = __DIR__.'/uploads/';
            if(!is_dir($uploadDir)){
                mkdir($uploadDir,0777,true);
            }
            $fileName = time() . '_'.$_FILES['image']['name'];
            $destination = $uploadDir . $fileName;

            move_uploaded_file($_FILES['image']['tmp_name'], $destination);

            
            $imagePath = 'uploads/' . $fileName;
        }
        $rentalObj = new Rental($pdo, $id, "", "", "", "", 0.0, 0, "", "");
        if($rentalObj->updateRental($id, $host_id, $title, $description, $address,  $city,  $price_per_night,  $capacity,  $imagePath,  $available_dates)){
            header('Location: Rental.php');
        }else{
            header('Location: update_rental.php');
        }
}
?>
