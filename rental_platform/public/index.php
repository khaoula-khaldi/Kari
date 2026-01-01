
<?php
require_once __DIR__.'/../src/User.php'; 

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur MyRental</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-pink-400 via-red-400 to-yellow-400 min-h-screen flex items-center justify-center">

    <!-- Carte centrale -->
    <div class="bg-white rounded-3xl shadow-2xl p-12 max-w-lg text-center">
        <!-- Logo / titre -->
        <h1 class="text-5xl font-bold text-gray-800 mb-4">MyRental</h1>
        <p class="text-gray-600 mb-8">Trouvez votre hébergement idéal ou devenez hôte.</p>

        <!-- Boutons -->
        <div class="flex flex-col gap-4">
            <a href="login.php" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-xl transition shadow-md transform hover:-translate-y-1">Se connecter</a>
            <a href="register.php" class="bg-white border-2 border-red-500 hover:bg-red-50 text-red-500 font-semibold py-3 px-6 rounded-xl transition shadow-md transform hover:-translate-y-1">S'inscrire</a>
        </div>

        <!-- Optionnel : petite note -->
        <p class="text-gray-400 mt-8 text-sm">Nous respectons votre vie privée. Aucune information ne sera partagée.</p>
    </div>

</body>
</html>
