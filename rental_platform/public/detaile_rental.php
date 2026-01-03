<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/rental.php';

// vérifier si connecté
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $id=$_POST['id'];
    // créer l'objet Rental
$rentalObj = new Rental($pdo, $id, "", "", "", "", 0.0, 0, "", "");

// récupérer tous les logements
$rentals = $rentalObj->affichRentalById($id);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des logements</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<main class="max-w-7xl mx-auto p-6">
    <h1 class="text-4xl font-bold mb-8">Mes Logements</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col">
                <!-- Image -->
                <img src="<?= htmlspecialchars($rentals['image_url']) ?>" alt="<?= htmlspecialchars($rentals['title']) ?>" class="h-48 w-full object-cover rounded-xl mb-4">

                <!-- Title & City -->
                <h2 class="text-xl font-semibold mb-1"><?= htmlspecialchars($rentals['title']) ?></h2>
                <p class="text-gray-500 mb-2"><?= htmlspecialchars($rentals['city']) ?></p>

                <!-- Description -->
                <p class="text-gray-700 mb-2 line-clamp-3"><?= htmlspecialchars($rentals['description']) ?></p>

                <!-- Price & Capacity -->
                <div class="flex justify-between items-center mb-4">
                    <span class="font-bold text-red-500"><?= htmlspecialchars($rentals['price_per_night']) ?> MAD / nuit</span>
                    <span class="text-gray-600"><?= htmlspecialchars($rentals['capacity']) ?> personnes</span>
                </div>

                <!-- Actions -->
                <div class="flex gap-2 mt-auto">
                    <a href="update_rental.php?id=<?= $rentals['id'] ?>" class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-white py-2 rounded-xl text-center transition">Modifier</a>
                    <form action="delete_rental.php" method="POST" class="flex-1">
                        <input type="hidden" name="id" value="<?= $rentals['id'] ?>">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 rounded-xl w-full transition">Supprimer</button>
                    </form>
                    <a href="allRental.php" class="text-gray-500 mb-2"><-Retour</a>
                </div>
            </div>
        
    </div>
</main>

</body>
</html>
