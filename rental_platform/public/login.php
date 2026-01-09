<?php
require_once __DIR__.'/../config/config.php';
require_once __DIR__.'/../src/User.php';

// créer PDO
$database = new Database();
$pdo = $database->getConnection();

$errorMessage = '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - MyRental</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-pink-400 via-red-400 to-yellow-400 min-h-screen flex items-center justify-center">
<div class="bg-white rounded-3xl shadow-2xl p-12 max-w-md w-full text-center">
    <h1 class="text-4xl font-bold text-gray-800 mb-6">Se connecter</h1>

    <?php if($errorMessage): ?>
        <p class="text-red-500 mb-4"><?= $errorMessage ?></p>
    <?php endif; ?>

    <form action="login.php" method="post" class="flex flex-col gap-4">
        <input type="email" name="email" placeholder="Email" required
            class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">

        <input type="password" name="password" placeholder="Mot de passe" required
            class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">

        <button type="submit"
            class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-xl shadow-md transform hover:-translate-y-1 transition">
            Connexion
        </button>
    </form>

    <p class="text-gray-500 mt-6">Pas encore inscrit ? 
        <a href="register.php" class="text-red-500 font-semibold hover:underline">S'inscrire ici</a>
    </p>
</div>
</body>
</html>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];
    

    $user = new User($pdo, '', $email, $password, '');
    if ($user->login()) {

        switch ($_SESSION['user_role']) {
            case 'admin':
                header('Location: profilAdmin.php');
                break;

            case 'host':
                header('Location: profilHost.php');
                break;

            default:
                header('Location: profil.php');
        }
        exit;



    } else {
        header('Location: erreurDesactivation.php');
        exit;
    }

}
?>