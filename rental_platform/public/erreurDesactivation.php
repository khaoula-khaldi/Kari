
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Erreur de connection</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<!-- Card d'erreur -->
<div class="bg-white shadow-xl rounded-2xl p-10 max-w-lg text-center">
    <!-- Icône d'erreur -->
    <div class="flex justify-center mb-6">
        <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>

    <!-- Titre -->
    <h1 class="text-2xl font-bold text-red-600 mb-4">Problème de connection</h1>

    <!-- Message -->
    <p class="text-gray-700 mb-6 text-lg">
        Attention : Une erreur de connexion est survenue. Veuillez réessayer plus tard.
    </p>

    <!-- Bouton retour -->
    <a href="login.php" class="bg-red-500 text-white px-6 py-3 rounded-xl hover:bg-red-600 transition">
        Retour aux connection 
    </a>
</div>

</body>
</html>
