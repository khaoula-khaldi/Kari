<?php 
    require_once __DIR__."/../src/rental.php";
    require_once __DIR__.'/../config/config.php';
    session_start();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un logement - MyRental</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<header class="bg-white shadow-md fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-red-500">MyRental</h1>
        <nav class="flex gap-6">
            <a href="dashboard.php" class="text-gray-700 hover:text-red-500 font-semibold">Dashboard</a>
            <a href="logout.php" class="text-gray-700 hover:text-red-500 font-semibold">Déconnexion</a>
            <a href="Rental.php" class="text-gray-700 hover:text-red-500 font-semibold">Rental</a>
        </nav>
    </div>
</header>

<main class="pt-24 max-w-4xl mx-auto px-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Ajouter un nouveau logement</h2>


    <form action="" method="post" enctype="multipart/form-data" class="bg-white rounded-2xl shadow p-6 flex flex-col gap-4">
        <input type="text" name="title" placeholder="Titre du logement" required
               class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">

        <textarea name="description" placeholder="Description" rows="4" required
                  class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400"></textarea>

        <input type="text" name="address" placeholder="Adresse" required
               class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">

        <input type="text" name="city" placeholder="Ville" required
               class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">

        <input type="number" step="0.01" name="price_per_night" placeholder="Prix par nuit (€)" required
               class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">

        <input type="number" name="capacity" placeholder="Capacité (nombre de personnes)" required
               class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">

        <input type="text" name="available_dates" placeholder="Dates disponibles (ex: 2026-01-01,2026-01-05)" required
               class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">

        <label class="font-semibold">Image du logement:</label>
        <input type="file" name="image" accept="image/*"
               class="border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">

        <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-xl shadow-md transform hover:-translate-y-1 transition">
            Ajouter le logement
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

        $longment=new Rental($pdo,$host_id,$title,$description, $address, $city, $price_per_night, $capacity,$imagePath, $available_dates);
        if($longment->create()){
            header('Location: Rental.php');
        }else{
            header('Location: register.php');
        }
        
        

    }

?>