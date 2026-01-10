
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
    
    $userModel = new User($pdo, '', '', '', '');
    $users = $userModel->getAllUser();
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
            <a href="dashbord.php" class="text-gray-700 hover:text-red-500 font-semibold">Utilisateurs</a>
            <a href="profilAdmin.php" class="text-gray-700 hover:text-red-500 font-semibold">Profil</a>
            <a href="rentalAdmin.php" class="text-gray-700 hover:text-red-500 font-semibold">Longment</a>
            <a href="bookingsAdmin.php" class="text-gray-700 hover:text-red-500 font-semibold">Reservation</a>
            <a href="statisticAdmin.php" class="text-gray-700 hover:text-red-500 font-semibold">Statistique</a>
            <a href="logout.php" class="text-gray-700 hover:text-red-500 font-semibold">Déconnexion</a>
        </nav>
    </div>
</header>

<main class="pt-24 max-w-6xl mx-auto px-6">
    <section class="py-10 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-gray-900 border-b-2 border-indigo-500 inline-block pb-2">Utilisateurs</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($users as $r): ?>
                <div class="bg-white rounded-3xl shadow-lg p-6 hover:scale-105 transition-transform duration-300">
                    <div class="flex flex-col space-y-3">
                        <h3 class="text-xl font-bold text-gray-800"><?= $r['name'] ?></h3>
                        <p class="text-gray-600"><span class="font-semibold">Role:</span> <?= $r['role'] ?></p>
                        <p class="text-gray-600"><span class="font-semibold">Email:</span> <?= $r['email'] ?></p>
                    </div>
                    <form action="deactiveUsers.php" method="POST">
                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                            <button type="submit" name="is_active" 
                                value="<?= $r['is_active']==='active' ? 'inactive' : 'active' ?>" 
                                class="mt-4 w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-xl shadow-md transition-colors duration-200">
                                <?= $r['is_active']==='active' ? 'Desactive' : 'Active' ?>
                            </button>
                    </form>

                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</main>
</body>
</html>
