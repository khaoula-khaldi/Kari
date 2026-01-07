<?php 

require_once __DIR__."/../config/config.php";
// créer PDO
$database = new Database();
$pdo = $database->getConnection();

class Rental{
    private int $id;
    private int $host_id;
    private string $title;
    private string $description;
    private string $address;
    private string $city;
    private float $price_per_night;
    private int $capacity;
    private string $image_url;
    private string $available_dates;
    private PDO $pdo;



    public function __construct(PDO $pdo, int $host_id, string $title, string $description, string $address, string $city, float $price_per_night, int $capacity, string $image_url, string $available_dates){
      
        $this->host_id = $host_id;
        $this->title = $title;
        $this->description = $description;
        $this->address = $address;
        $this->city = $city;
        $this->price_per_night = $price_per_night;
        $this->capacity = $capacity;
        $this->image_url = $image_url;
        $this->available_dates = $available_dates;
        $this->pdo=$pdo;
    }


    public function create(): bool {
        $stmt = $this->pdo->prepare("INSERT INTO rentals (host_id, title, description, address, city, price_per_night, capacity, image_url, available_dates) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$this->host_id, $this->title, $this->description, $this->address, $this->city, $this->price_per_night, $this->capacity, $this->image_url, $this->available_dates]);
    }

    public function affichRental(int $host_id): array {
        $stmt = $this->pdo->prepare("SELECT * FROM rentals WHERE host_id=?");
        $stmt->execute([$host_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        public function affichRentalById(int $id): array {
        $stmt = $this->pdo->prepare("SELECT * FROM rentals WHERE id=?");
        $stmt->execute([$id]);
        $data= $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ?: [];
    }



    public function deletRental(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM rentals WHERE id=?");
        return $stmt->execute([$id]);
    }  
    
    public function updateRental(  int $id,int $host_id,string $title,string $description,string $address, string $city, float $price_per_night, int $capacity, string $image_url, string $available_dates): bool {
        $stmt=$this->pdo->prepare("UPDATE rentals SET title=?, description=?,  address=?, city=?, price_per_night=?, capacity=?, image_url=?, available_dates=? WHERE id=? AND host_id=?");
        return $stmt->execute([$title, $description, $address, $city, $price_per_night,$capacity,$image_url,$available_dates,$id,$host_id]);
    }

    public function affichAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM rentals");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($city=null,$price_per_night=null,$available_dates=null){
        $sql="SELECT * FROM rentals WHERE 1=1 ";
        $parametres=[];

        if(!empty($city)){
            $sql.="AND city=:city ";
            $parametres['city']=$city;
        }

        if(!empty($price)){
            $sql.="AND price=:price ";
            $parametres['price']=$price;
        }

        if(!empty($available_dates)){
            $sql.="AND available_dates=:available_dates ";
            $parametres['available_dates']=$available_dates;
        }

       $stmt=$this->pdo->prepare($sql);
       $stmt->execute($parametres);
       
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>