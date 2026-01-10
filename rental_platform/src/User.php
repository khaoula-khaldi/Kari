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
    private PDO $pdo; 

    public function __construct($pdo, string $nom, string $email, string $password, string $role) {
        $this->pdo = $pdo;
        $this->nom = $nom;
        $this->email = $email;
        $this->password = $password; 
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
            return false; 
        }
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([
            $this->nom,
            $this->email,
            password_hash($this->password, PASSWORD_DEFAULT), 
            $this->role
        ]);
    }

    public function login(): bool {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=? && is_active='active'");
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

    public function getAllUser():array{
        $stmt=$this->pdo->prepare("SELECT * FROM users WHERE role!='admin'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Is_Active($value,$id){
        $stmt=$this->pdo->prepare("UPDATE users SET is_active=? WHERE id=?");
       return $stmt->execute([$value,$id]);
    }

   

    public function cancelAdmin(int $reservation_id): bool {
        $stmt = $this->pdo->prepare("UPDATE reservations SET status='cancelled' WHERE id=?");
        return $stmt->execute([$reservation_id]);
    }

    public function accepteAdmin(int $reservation_id): bool {
        $stmt = $this->pdo->prepare("UPDATE reservations SET status='confirmed' WHERE id=?");
        return $stmt->execute([$reservation_id]);
    }

    public function cancel(int $reservation_id, $user_id): bool {
            $stmt = $this->pdo->prepare("DELETE FROM reservations WHERE id=? AND user_id=?");
            return $stmt->execute([$reservation_id, $user_id]);
    }
}
