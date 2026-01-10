
 <?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/User.php';
require_once __DIR__ . '/../src/rental.php';
require_once __DIR__ . '/../src/Booking.php';

$database = new Database();
$pdo = $database->getConnection();

// Vérifier si user connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$booking=new Booking($pdo);
$affich=$booking->getAllReservation();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Admin | Réservations</title>
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
<main class="p-6">
  <h2 class="text-3xl font-bold mb-6 text-gray-800">
    Toutes les réservations
  </h2>

  <!-- TABLE -->
  <div class="overflow-x-auto bg-white rounded-2xl shadow">
    <table class="min-w-full text-left">
      <thead class="bg-gray-100 text-gray-700">
        <tr>
          <th class="px-6 py-4">Client</th>
          <th class="px-6 py-4">Email</th>
          <th class="px-6 py-4">Logement</th>
          <th class="px-6 py-4">Date début</th>
          <th class="px-6 py-4">Date fin</th>
          <th class="px-6 py-4">Statut</th>
          <th class="px-6 py-4 text-center">Actions</th>
        </tr>
      </thead>

<tbody>
<?php foreach ($affich as $a): ?>
  <tr class="border-b hover:bg-gray-50">
    <td class="px-6 py-4 font-medium">
      <?= htmlspecialchars($a['name']) ?>
    </td>

    <td class="px-6 py-4 text-gray-600">
      <?= htmlspecialchars($a['email']) ?>
    </td>

    <td class="px-6 py-4">
      <?= htmlspecialchars($a['title']) ?>
    </td>

    <td class="px-6 py-4">
      <?= $a['date_debut'] ?>
    </td>

    <td class="px-6 py-4">
      <?= $a['date_fin'] ?>
    </td>

    <td class="px-6 py-4">
      <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700">
        <?= $a['status'] ?? 'pending' ?>
      </span>
    </td>

    <td class="px-6 py-4 text-center space-x-3">
      <form action="anulerBookingAdmin.php" method="POST">
        <input type="text" name="reservation_id" $value="<?= htmlspecialchars($a['reservation_id']) ?>">
      <button class="text-red-500 hover:underline">Annuler</button>
      </form>
    </td>
  </tr>
<?php endforeach; ?>
</tbody>

    </table>
  </div>
</main>

</body>
</html>
                