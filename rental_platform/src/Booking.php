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

    public function create($user_id,$rental_id,$start_date,$end_date){

        $stmt=$this->pdo->prepare("INSERT INTO reservations(user_id,rental_id,start_date,end_date)VALUES(?,?,?,?)");
        return $stmt->execute([$user_id,$rental_id,$start_date,$end_date]);
    }
   
    public function cancel(){
        
    }

    public function findUserBookings($user_id){
        $stmt = $this->pdo->prepare("
            SELECT 
                r.id AS reservation_id,
                r.rental_id,
                r.start_date,
                r.end_date,
                i.image_url,
                r.status AS reservation_status,
                i.title,
                i.city,
                i.price_per_night
            FROM reservations r
            JOIN rentals i ON r.rental_id = i.id
            WHERE r.user_id = :user_id
            ORDER BY r.start_date DESC
        ");

        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPricePerNight($rental_id){
    $stmt = $this->pdo->prepare(" SELECT price_per_night FROM rentals WHERE id=?");

    $stmt->execute([$rental_id]);
    return $stmt->fetch(PDO::FETCH_COLUMN); 
    }


    public function findRentalBookings($rental_id):array{
        $stmt=$this->pdo->prepare("SELECT * FROM reservations WHERE rental_id=?");
        $stmt->execute([$rental_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function calculeNbNights($start_date,$end_date) {

        $start = new DateTime($start_date);
        $end = new DateTime($end_date);

        if($end<=$start){
             
            exit;
        }

       return $start->diff($end)->days;
    }

    public function total_price ( int $rental_id, string $start_date, string $end_date){
       $nights=$this->calculeNbNights($start_date,$end_date);
       $price_night=$this->getPricePerNight($rental_id);
       return $nights*$price_night;
    }

    public function checkAvailability($rental_id,$start_date,$end_date):int {
        $stmt=$this->pdo->prepare("SELECT count(*) FROM reservations WHERE rental_id=? AND start_date<=? AND end_date>=?");
        $count=$stmt->execute([$rental_id,$start_date,$end_date]);
        $count=$stmt->fetchColumn();
        return $count;
    }

    public function getAllReservation(){
        $stmt=$this->pdo->prepare("SELECT users.name,users.email,rentals.title,reservations.start_date AS date_debut,reservations.end_date AS date_fin FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN rentals ON reservations.rental_id = rentals.id ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}