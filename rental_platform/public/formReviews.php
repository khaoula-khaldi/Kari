<?php

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un avis</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow w-full max-w-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Ajouter un avis</h1>


    <form method="POST" class="space-y-4">
        <!-- Rating -->
        <div>
            <label class="block mb-2 font-semibold text-gray-700">Note (1 à 5 étoiles)</label>
            <select name="rating" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">-- Sélectionner --</option>
                <option value="1">1 étoile</option>
                <option value="2">2 étoiles</option>
                <option value="3">3 étoiles</option>
                <option value="4">4 étoiles</option>
                <option value="5">5 étoiles</option>
            </select>
        </div>

        <!-- Comment -->
        <div>
            <label class="block mb-2 font-semibold text-gray-700">Commentaire</label>
            <textarea name="comment" rows="4" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Votre avis..."></textarea>
        </div>

        <!-- Submit -->
        <div class="text-right">
            <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600">
                Ajouter
            </button>
        </div>
    </form>
</div>

</body>
</html>
