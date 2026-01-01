<?php 
require_once __DIR__.'/../config/config.php';
require_once __DIR__.'/../src/User.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - MyRental</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-pink-400 via-red-400 to-yellow-400 min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-3xl shadow-2xl p-12 max-w-md w-full text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">S'inscrire</h1>
        
 

        <form action="register.php" method="post" class="flex flex-col gap-4">
            <input type="text" name="nom" placeholder="Nom complet" required
                class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">

            <input type="email" name="email" placeholder="Email" required
                class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">

            <input type="password" name="password" placeholder="Mot de passe" required
                class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">

            <select name="role" required
                class="border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-400">
                <option value="" disabled selected>-- Sélectionnez votre rôle --</option>
                <option value="admin">Admin</option>
                <option value="traveler">traveler</option>
                <option value="host">Host</option>
            </select>

            <button type="submit" name="submit"
                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-xl shadow-md transform hover:-translate-y-1 transition">
                S'inscrire
            </button>
        </form>

        <p class="text-gray-500 mt-6">Déjà inscrit ? 
            <a href="login.php" class="text-red-500 font-semibold hover:underline">Se connecter ici</a>
        </p>
    </div>

</body>
</html>

<?php 
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $nom=$_POST['nom'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $password_has=password_hash($password,PASSWORD_DEFAULT);
        $role=$_POST['role'];

        $user = new User($pdo, $nom, $email, $password, $role);

        if($user->register()){
            header('Location: login.php');
        }else{
            header('Location: register.php');
        }
    }
?>
