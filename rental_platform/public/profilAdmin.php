<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/User.php';

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
            <a href="home.php" class="text-gray-700 hover:text-red-500 font-semibold">Accueil</a>
            <a href="profilAdmin.php" class="text-gray-700 hover:text-red-500 font-semibold">Profil</a>
            <a href="reservations.php" class="text-gray-700 hover:text-red-500 font-semibold">Réservations</a>
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
                header('Location: profil.php'); // page après update
                exit;
            } else {
                $errorMessage = "Erreur lors de la mise à jour du profil";
            }
        }
    ?>

    <!-- Section Réservations (placeholder Airbnb style) -->
    <section>
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Mes réservations</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="font-semibold text-lg mb-2">Appartement Paris</h3>
                <p>Date: 12 Jan 2026 - 15 Jan 2026</p>
                <p>Status: <span class="text-green-600 font-semibold">Confirmée</span></p>
            </div>
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="font-semibold text-lg mb-2">Maison Marrakech</h3>
                <p>Date: 20 Jan 2026 - 25 Jan 2026</p>
                <p>Status: <span class="text-yellow-600 font-semibold">En attente</span></p>
            </div>
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="font-semibold text-lg mb-2">Studio Casablanca</h3>
                <p>Date: 05 Fév 2026 - 08 Fév 2026</p>
                <p>Status: <span class="text-red-600 font-semibold">Annulée</span></p>
            </div>
        </div>
    </section>
</main>
</body>
</html>
