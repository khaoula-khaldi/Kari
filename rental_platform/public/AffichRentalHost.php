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
            <a href="AffichRentalHost.php" class="text-gray-700 hover:text-red-500 font-semibold">Accueil</a>
            <a href="profilHost.php" class="text-gray-700 hover:text-red-500 font-semibold">Profil</a>
            <a href="Rental.php" class="text-gray-700 hover:text-red-500 font-semibold">Rentale</a>
            <a href="logout.php" class="text-gray-700 hover:text-red-500 font-semibold">Déconnexion</a>
        </nav>
    </div>
</header>

<main class="pt-32 max-w-6xl mx-auto px-6">

<!-- Recherche -->
<div class="bg-white rounded-2xl shadow p-6 mb-10 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-4">Recherche avancée</h2>

    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <input type="text" name="city" placeholder="Ville" class="border rounded-xl px-4 py-2">
        <input type="number" name="max_price" placeholder="Prix max" class="border rounded-xl px-4 py-2">
        <input type="date" name="start_date" class="border rounded-xl px-4 py-2">
        <input type="date" name="end_date" class="border rounded-xl px-4 py-2">
        <button type="submit"
                class="bg-red-500 text-white rounded-xl py-2 px-4 col-span-full md:col-auto">
            Rechercher
        </button>
    </form>
</div>




<!-- Résultats recherche -->
<?php if ($isSearch): ?>
    <section class="mb-10">
        <h2 class="text-2xl font-bold mb-4">Résultats de recherche</h2>

        <?php if (empty($results)): ?>
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-red-500 font-bold text-xl">Aucun logement trouvé</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach ($results as $r): ?>
                    <div class="bg-white rounded-2xl shadow p-6">
                        <h3 class="text-xl font-semibold"><?= htmlspecialchars($r['title']) ?></h3>
                        <p><?= htmlspecialchars($r['city']) ?></p>
                        <p class="font-semibold"><?= htmlspecialchars($r['price_per_night']) ?> € / nuit</p>
                        <p>Capacité: <?= htmlspecialchars($r['capacity']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>

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
                    <form action="detaile_rental.php" method="POST">
                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                        <button class="bg-yellow-400 px-4 py-2 rounded-xl text-white mt-5">
                            Voir détail
                        </button>
                    </form>

                    <form action="is_active.php" method="POST">
                        <input type="hidden" name="rental_id" value="<?= $r['id'] ?>">
                        <input type="hidden" name="user_id" value="<?= $r['host_id'] ?>">

                        <button class="bg-pink-400 px-4 py-2 rounded-xl text-white mt-5">
                            is_active
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
