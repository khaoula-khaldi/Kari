<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Hôte - Mes Logements</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Navbar -->
<header class="bg-white shadow-md fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-red-500">MyRental</h1>
        <nav class="flex gap-6">
            <a href="dashboard.php" class="text-gray-700 hover:text-red-500 font-semibold">Dashboard</a>
            <a href="profile.php" class="text-gray-700 hover:text-red-500 font-semibold">Profil</a>
            <a href="logout.php" class="text-gray-700 hover:text-red-500 font-semibold">Déconnexion</a>
        </nav>
    </div>
</header>

<main class="pt-24 max-w-6xl mx-auto px-6">

    <!-- Section Mes Logements -->
    <section class="mb-10">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Mes Logements</h2>
            <a href="add_rental.php"
               class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition">
                + Ajouter un logement
            </a>
        </div>

        <!-- Grid des logements -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Exemple de carte logement (à générer dynamiquement avec PHP) -->
            <div class="bg-white rounded-2xl shadow p-6 flex flex-col">
                <img src="image_logement.jpg" alt="Titre logement" class="rounded-xl mb-4 h-48 w-full object-cover">
                <h3 class="text-xl font-semibold mb-2">Appartement Paris</h3>
                <p class="text-gray-600 mb-2">Paris, France</p>
                <p class="text-gray-800 font-semibold mb-2">Prix par nuit: 120€</p>
                <p class="text-gray-600 mb-4">Capacité: 4 personnes</p>

                <div class="mt-auto flex gap-2">
                    <a href="edit_rental.php?id=1"
                       class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 px-4 rounded-xl transition">
                        Modifier
                    </a>
                    <a href="delete_rental.php?id=1"
                       class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-xl transition">
                        Supprimer
                    </a>
                </div>
            </div>

            <!-- Tu peux répéter cette carte pour chaque logement de l'hôte -->
        </div>
    </section>
</main>

</body>
</html>
