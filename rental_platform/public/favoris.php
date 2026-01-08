<?php
session_start();

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../src/Favorise.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$database = new Database();
$pdo = $database->getConnection();

$user_id = $_SESSION['user_id'];

$favorisModel = new Favorie($pdo);
$favoris = $favorisModel->findUserFavorites($user_id);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mes Favoris</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-7xl mx-auto px-6 py-8">

  <h1 class="text-2xl font-bold mb-6">❤️ Mes Favoris</h1>

  <?php if (!empty($favoris)): ?>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    <?php foreach ($favoris as $rental): ?>
      <div class="bg-white rounded-xl shadow-md overflow-hidden relative">

        <img src="<?= htmlspecialchars($rental['image_url']) ?>"
             class="w-full h-48 object-cover">

        <div class="p-4">
          <p class="text-sm text-gray-500">
            📍 <?= htmlspecialchars($rental['city']) ?>
          </p>

          <h2 class="text-lg font-semibold mt-1">
            <?= htmlspecialchars($rental['title']) ?>
          </h2>

          <p class="text-lg font-bold mt-3">
            <?= htmlspecialchars($rental['price_per_night']) ?> $
            <span class="text-sm font-normal text-gray-500">/ nuit</span>
          </p>
              <form action="annelerFavoris.php" method="POST">
                  <input type="hidden" name="rental_id" value="<?= (int)$rental['rental_id'] ?>">
                  <button class="block text-center mt-4 bg-rose-500 text-white py-2 px-10 rounded-lg">
                      Annuler
                  </button>
              </form>
        </div>
      </div>
    <?php endforeach; ?>

  </div>
  <?php else: ?>
    <div class="text-center py-20 text-gray-500">
      😢 Vous n’avez aucun Favorise
    </div>

  <?php endif; ?>
  
          <a href="allRental.php"
             class="block text-center mt-4 bg-rose-500 hover:bg-rose-600 text-white py-2 rounded-lg">Retour a page des renlaes
          </a>

</div>

</body>
</html>
