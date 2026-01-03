<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/rental.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$rentalObj = new Rental($pdo, $_SESSION['user_id'], "", "", "", "", 0.0, 0, "", "");

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['id'])){
    $id = (int) $_POST['id'];
    $rental = $rentalObj->affichRentalById($id);

    if(empty($rental)){
        die("Logement non trouvé");
    }

    
    if($rental['host_id'] !== $_SESSION['user_id']){
        die("Accès refusé");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier logement</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<main class="max-w-4xl mx-auto pt-24 px-6">
    <h2 class="text-3xl font-bold mb-6">Modifier le logement</h2>

    <form method="POST"  enctype ="multipart/form-data"
          class="bg-white p-6 rounded-2xl shadow flex flex-col gap-4">
        
        <input type="text" name="title"
               value="<?= htmlspecialchars($rental['title']) ?>"
               class="border rounded-xl px-4 py-3" required>

        <textarea name="description"
                  class="border rounded-xl px-4 py-3"
                  required><?= htmlspecialchars($rental['description']) ?></textarea>

        <input type="text" name="address"
               value="<?= htmlspecialchars($rental['address']) ?>"
               class="border rounded-xl px-4 py-3" required>

        <input type="text" name="city"
               value="<?= htmlspecialchars($rental['city']) ?>"
               class="border rounded-xl px-4 py-3" required>

        <input type="number" step="0.01" name="price_per_night"
               value="<?= htmlspecialchars($rental['price_per_night']) ?>"
               class="border rounded-xl px-4 py-3" required>

        <input type="number" name="capacity"
               value="<?= htmlspecialchars($rental['capacity']) ?>"
               class="border rounded-xl px-4 py-3" required>

        <input type="text" name="available_dates"
               value="<?= htmlspecialchars($rental['available_dates']) ?>"
               class="border rounded-xl px-4 py-3" required>

        <div>
            <p class="font-semibold mb-2">Image actuelle</p>
            <img src="<?= htmlspecialchars($rental['image_url']) ?>"
                 class="h-32 rounded mb-2">
            <input type="file" name="image">
        </div>

        <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl">
            Mettre à jour
        </button>
    </form>
</main>

</body>
</html>

<?php 
    if($_SERVER['REQUEST_METHOD']==='POST'){
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

        if($rentalObj->updateRental($_SESSION['user_id'], $host_id, $title, $description, $address,  $city,  $price_per_night,  $capacity,  $imagePath,  $available_dates)){
            header('Location: Rental.php');
        }else{
            header('Location: update_rental.php');
        }
    }
?>
