<?php 
require_once __DIR__."/../config/config.php";
// créer PDO
$database = new Database();
$pdo = $database->getConnection();


class Booking{
    private int $id;
    private int $rental_id;
    private int $user_id;
    private string $start_date;
    private string $end_date;
    private float $total_price;
    private string $status;
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo=$pdo;
    }

    public function create($id,$user_id,$rental_id,$start_date,$end_date,$total_price,$status){
        $stmt=$this->pdo->prepare("INSERT INTO reservation(user_id,rental_id,start_date,end_date,status)VALUES(?,?,?,?,?)");
        return $stmt->execute([$user_id,$rental_id,$start_date,$end_date,$status]);
    }

    public function cancel($id){
        $stmt = $this->pdo->prepare("DELETE * FROM resercation WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function findUserBookings($user_id){
        $stmt=$this->pdo->prepare("SELECT * FROM reservation WHERE user_id=?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findRentalBookings($rental_id):array{
        $stmt=$this->pdo->prepare("SELECT * FROM resirvation WHERE rental_id=?");
        $stmt->execute([$rental_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkAvailability($rental_id,$start_date,$end_date){
        
    }

}