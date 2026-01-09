
 <?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/Statistics.php';


$database = new Database();
$pdo = $database->getConnection();

// Vérifier si user connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$Statistics=new Statistics($pdo);
$TotalUsers=$Statistics->getTotalUsers();
$TotalRentals=$Statistics->getTotalRentals();
$TotalBooking=$Statistics->getTotalBookings();
$TotalRevenu=$Statistics->getTotalRevenue();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- HEADER -->
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
<!-- CONTENT -->
<main class="pt-28 px-6 max-w-7xl mx-auto">

    <!-- STATS CARDS -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Total Utilisateurs</p>
            <h2 class="text-3xl font-bold mt-2"><?= htmlspecialchars($TotalUsers)  ?></h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Total Logements</p>
            <h2 class="text-3xl font-bold mt-2"><?= htmlspecialchars($TotalRentals) ?></h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Total Réservations</p>
            <h2 class="text-3xl font-bold mt-2"><?= htmlspecialchars($TotalBooking) ?></h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Revenus Totaux</p>
            <h2 class="text-3xl font-bold mt-2 text-green-600">
         <?=  htmlspecialchars($TotalRevenu) ?> MAD
            </h2>
        </div>

    </section>

    <!-- TOP RENTALS -->
    <section class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">
            Top 10 Logements les plus rentables
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Titre</th>
                        <th class="px-6 py-3">Revenu (MAD)</th>
                    </tr>
                </thead>
                <tbody>
                <?php ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4"> </td>
                        <td class="px-6 py-4 font-medium">
                           
                        </td>
                        <td class="px-6 py-4 text-green-600 font-semibold">
                          
                        </td>
                    </tr>
                
                </tbody>
            </table>
        </div>
    </section>

</main>

</body>
</html>
