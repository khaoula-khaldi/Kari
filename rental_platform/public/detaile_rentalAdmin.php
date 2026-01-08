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
    <title>Détail du logement</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<main class="max-w-6xl mx-auto p-6">

    <!-- Retour -->
    <a href="allRental.php" class="text-gray-500 hover:text-red-500 mb-6 inline-block">
        ← Retour aux logements
    </a>

    

        <!-- ===== LEFT : DÉTAIL LOGEMENT ===== -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow overflow-hidden">

            <!-- Image -->
            <img 
                src="<?= htmlspecialchars($rentals['image_url']) ?>" 
                alt="<?= htmlspecialchars($rentals['title']) ?>" 
                class="w-full h-96 object-cover"
            >

            <div class="p-6">
                <!-- Titre -->
                <h1 class="text-3xl font-bold mb-2">
                    <?= htmlspecialchars($rentals['title']) ?>
                </h1>

                <!-- Ville -->
                <p class="text-gray-500 mb-4">
                    📍 <?= htmlspecialchars($rentals['city']) ?>
                </p>

                <!-- Infos -->
                <div class="flex gap-6 mb-6">
                    <span class="text-red-500 font-bold text-lg">
                        <?= htmlspecialchars($rentals['price_per_night']) ?> MAD / nuit
                    </span>
                    <span class="text-gray-700">
                        👥 <?= htmlspecialchars($rentals['capacity']) ?> personnes
                    </span>
                </div>

                <!-- Description -->
                <h2 class="text-xl font-semibold mb-2">Description</h2>
                <p class="text-gray-700 leading-relaxed">
                    <?= htmlspecialchars($rentals['description']) ?>
                </p>
               
            </div>
        </div>

    
</main>

</body>
</html>
