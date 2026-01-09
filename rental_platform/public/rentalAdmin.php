<?php
session_start();

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../src/rental.php";


$database = new Database();
$pdo = $database->getConnection();

$rental = new Rental($pdo, $_SESSION['user_id'], "", "", "", "", 0.0, 0, "", "");

$allRentals = $rental->affichAll();

$results = [];
$isSearch = false;


if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET)) {

    $city = !empty($_GET['city']) ? $_GET['city'] : null;
    $max_price = !empty($_GET['max_price']) ? $_GET['max_price'] : null;

    $available_dates = null;
    if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $available_dates = [
            'start' => $_GET['start_date'],
            'end'   => $_GET['end_date']
        ];
    }

    if ($city || $max_price || $available_dates) {
        $results = $rental->search($city, $max_price, $available_dates);
        $isSearch = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rentals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>

<body class="bg-gray-100 min-h-screen">

<header class="bg-white shadow-md fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-red-500">MyRental</h1>
        <nav class="flex gap-6">
            <a href="dashbord.php" class="text-gray-700 hover:text-red-500 font-semibold">Utilisateurs</a>
            <a href="profilAdmin.php" class="text-gray-700 hover:text-red-500 font-semibold">Profil</a>
            <a href="rentalAdmin.php" class="text-gray-700 hover:text-red-500 font-semibold">Longment</a>
            <a href="bookingsAdmin.php" class="text-gray-700 hover:text-red-500 font-semibold">Reservation</a>
            <a href="statisticAdmin.php" class="text-gray-700 hover:text-red-500 font-semibold">Statistique</a>
            <a href="logout.php" class="text-gray-700 hover:text-red-500 font-semibold">Déconnexion</a>
        </nav>
    </div>
</header>


<main class="pt-32 max-w-6xl mx-auto px-6">


<!-- Tous les logements -->
<section class="mb-10">
    <h2 class="text-3xl font-bold mb-6">Tous les logements</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($allRentals as $r): ?>
            <div class="bg-white rounded-2xl shadow p-6">
                <img src="<?= htmlspecialchars($r['image_url']) ?>"
                     class="rounded-xl h-48 w-full object-cover mb-4">

                <h3 class="text-xl font-semibold"> <?= htmlspecialchars($r['title']) ?></h3>
                <p>ville: <?= htmlspecialchars($r['city']) ?></p>
                <p class="font-semibold">prix : <?= htmlspecialchars($r['price_per_night']) ?> €</p>
                <div class="flex flex-row justify-between">
                    <form action="detaile_rentalAdmin.php" method="POST">
                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                        <button class="bg-yellow-400 px-4 py-2 rounded-xl text-white mt-5">
                            Voir détail
                        </button>
                    </form>

                    <form action="desactiver_rental.php" method="POST">
                        <input type="hidden" name="rental_id" value="<?= $r['id'] ?>">
                        <input type="hidden" name="user_id" value="<?= $r['host_id'] ?>">

                        <button class="bg-pink-400 px-4 py-2 rounded-xl text-white mt-5">
                            Desactiver
                        </button>
                    </form>

                    <form action="active_rental.php" method="POST">
                        <input type="hidden" name="rental_id" value="<?= $r['id'] ?>">
                        <input type="hidden" name="user_id" value="<?= $r['host_id'] ?>">

                        <button class="bg-pink-400 px-4 py-2 rounded-xl text-white mt-5">
                            Activer
                        </button>
                    </form>
                </div>
                
            </div>
        <?php endforeach; ?>
    </div>
</section>

</main>
</body>
</html>
