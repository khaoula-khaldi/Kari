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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-50">

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

        <!-- ===== RIGHT : RÉSERVATION ===== -->
        <div class="bg-white rounded-2xl shadow p-6 m-10 h-fit sticky top-6">

            <h2 class="text-2xl font-bold mb-4">
                Réserver ce logement
            </h2>

            <form action="reservation_rental.php" method="POST" class="space-y-4">

                <input type="hidden" name="rental_id" value="<?= $rentals['id'] ?>">

                <!-- Date début -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">
                        Date de début
                    </label>
                    <input 
                        type="date" 
                        name="start_date" 
                        required
                        class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400"
                    >
                </div>

                <!-- Date fin -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">
                        Date de fin
                    </label>
                    <input 
                        type="date" 
                        name="end_date" 
                        required
                        class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400"
                    >
                </div>

                <button 
                    type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-xl transition"
                >
                    Réserver maintenant
                </button>

            </form>
        </div>

    </div>
</main>

</body>
</html>
