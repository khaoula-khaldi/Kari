<?php
session_start();
$user_id=$_SESSION['user_id'];
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/User.php';
require_once __DIR__ . '/../src/Booking.php';

$database = new Database();
$pdo = $database->getConnection();

// Vérifier si user connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil - MyRental</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Navbar -->
<header class="bg-white shadow-md fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-red-500">MyRental</h1>
        <nav class="flex gap-6">
            <a href="allRental.php" class="text-gray-700 hover:text-red-500 font-semibold">Accueil</a>
            <a href="profil.php" class="text-gray-700 hover:text-red-500 font-semibold">Profil</a>
            <a href="favoris.php" class="text-gray-700 hover:text-red-500 font-semibold">Mes Favoris</a>
            <a href="logout.php" class="text-gray-700 hover:text-red-500 font-semibold">Déconnexion</a>
        </nav>
    </div>
</header>

<main class="pt-24 max-w-6xl mx-auto px-6">
    <!-- Section Profil -->
    <section class="mb-10">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Mon Profil</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Card info user -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-xl font-semibold mb-4">Informations personnelles</h3>
                <p><span class="font-semibold">Nom:</span> <?= $_SESSION['user_name'] ?></p>
                <p><span class="font-semibold">Email:</span> <?= $_SESSION['user_email'] ?></p>
                <p><span class="font-semibold">Role:</span> <?= $_SESSION['user_role'] ?></p>
            </div>

            <?php if(isset($errorMessage)): ?>
                <p class="text-red-500 mb-4"><?= $errorMessage ?></p>
            <?php endif; ?>

            <!-- Card Form update -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-xl font-semibold mb-4">Modifier mon profil</h3>
                
                <form method="post" class="flex flex-col gap-4">
                    <input type="text" name="nom" value="<?= $_SESSION['user_name'] ?>" placeholder="Nom complet" required
                           class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    <input type="email" name="email" value="<?= $_SESSION['user_email'] ?>" placeholder="Email" required
                           class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-xl shadow-md transform hover:-translate-y-1 transition">
                        Mettre à jour
                    </button>
                </form>
            </div>
        </div>
    </section>

    <?php
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $name=$_POST['nom'];
            $email=$_POST['email'];
            $user = new User($pdo, $name, $email, '', '');
            if($user->update()){
                header('Location: profil.php'); // page apres
                exit;
            } else {
                $errorMessage = "Erreur lors de la mise à jour du profil";
            }
        }
    ?>

    <!--  Reservations -->
    <section>
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Mes réservations</h2>
        <?php $BookingObj=new Booking($pdo);
            $bookings =$BookingObj->findUserBookings($user_id);
         ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach($bookings as $r): 
                    $total_price = $BookingObj->total_price($r['rental_id'], $r['start_date'], $r['end_date']);
                ?>
                <div class="bg-white rounded-2xl shadow p-6">
                    <img src="<?= htmlspecialchars($r['image_url']) ?>" alt="<?= htmlspecialchars($r['title']) ?>" class="rounded-xl mb-4 h-48 w-full object-cover">
                    <h3 class="font-semibold text-lg mb-2"><?= htmlspecialchars($r['title']) ?></h3>
                    <p>Date: <?= htmlspecialchars($r['start_date']) ?> - <?= htmlspecialchars($r['end_date']) ?></p>
                    <p>Status: <span class="text-green-600 font-semibold"><?= htmlspecialchars($r['reservation_status']) ?></span></p>
                    <p>Price total: <?= htmlspecialchars($total_price) ?> €</p>

                <form method="POST" action="cancel_booking.php">
                    <input type="hidden" name="reservation_id" value="<?= $r['reservation_id'] ?>">
                    <button type="submit" class="bg-red-400 px-4 py-2 rounded-xl text-white mt-5">Annuler</button>
                </form>
                </div>
                <?php endforeach; ?>
        </div>
    </section>
</main>
</body>
</html>
