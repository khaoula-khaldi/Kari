<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/Review.php';

// Vérifier si user connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$database = new Database();
$pdo = $database->getConnection();
$review = new Review($pdo);

$rental_id = $_GET['rental_id'] ?? null; // ID du logement

if (!$rental_id) {
    echo "Logement introuvable.";
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = (int) $_POST['rating'];
    $comment = trim($_POST['comment']);
    $user_id = $_SESSION['user_id'];

    if ($rating >= 1 && $rating <= 5 && $comment !== '') {
        if ($review->create($user_id, $rental_id, $rating, $comment)) {
            $message = "Votre avis a été ajouté avec succès !";
        } else {
            $message = "Erreur: Vous avez peut-être déjà donné un avis pour ce logement.";
        }
    } else {
        $message = "Veuillez mettre une note entre 1 et 5 et un commentaire.";
    }
}
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

    <?php if($message): ?>
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

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
