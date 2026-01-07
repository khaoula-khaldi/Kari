<?php 
require_once __DIR__."/../config/config.php";


// créer PDO
$database = new Database();
$pdo = $database->getConnection();

class User {
    // protected int $id;
    protected string $nom;
    protected string $email;
    protected string $password;
    protected string $role;
    protected $pdo; 

    public function __construct($pdo, string $nom, string $email, string $password, string $role) {
        $this->pdo = $pdo;
        $this->nom = $nom;
        $this->email = $email;
        $this->password = $password; // plaintext pour login
        $this->role = $role;
        // $this->id = $id;
    }

    public function isAdmin(): bool {
        return $this->role === 'admin';
    }

    public function isHost(): bool {
        return $this->role === 'host';
    }

    public function isTraveler(): bool {
        return $this->role === 'traveler';
    }

    public function emailExists(): bool {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email=?");
        $stmt->execute([$this->email]);
        return $stmt->rowCount() > 0;
    }

    public function register(): bool {
        if($this->emailExists()){
            return false; // email déjà exist
        }
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([
            $this->nom,
            $this->email,
            password_hash($this->password, PASSWORD_DEFAULT), // hash ici
            $this->role
        ]);
    }

    public function login(): bool {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$this->email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$user) return false;

    
        if(!password_verify($this->password, $user['password'])) return false;

        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];

        return true;
    }

    public function update(): bool {
    // Session start wajib ila mazal ma startach
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }

    $stmt = $this->pdo->prepare("UPDATE users SET name=?, email=? WHERE id=?");
    $success = $stmt->execute([$this->nom, $this->email, $_SESSION['user_id']]);

    // Refresh session si update réussi
    if($success){
        $_SESSION['user_name'] = $this->nom;
        $_SESSION['user_email'] = $this->email;
    }

    return $success;
}


}
?>
