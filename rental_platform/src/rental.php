<?php 
require_once __DIR__."User.php";


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

    private $pdo;

    public function __construct($pdo, int $host_id, string $title, string $description, string $address, string $city, float $price_per_night, int $capacity, string $image_url, string $available_dates){
        $this->pdo = $pdo;
        $this->host_id = $host_id;
        $this->title = $title;
        $this->description = $description;
        $this->address = $address;
        $this->city = $city;
        $this->price_per_night = $price_per_night;
        $this->capacity = $capacity;
        $this->image_url = $image_url;
        $this->available_dates = $available_dates;
    }

    public function create(): bool {
        $stmt = $this->pdo->prepare("INSERT INTO rentals (host_id, title, description, address, city, price_per_night, capacity, image_url, available_dates) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$this->host_id, $this->title, $this->description, $this->address, $this->city, $this->price_per_night, $this->capacity, $this->image_url, $this->available_dates]);
    }

}
?>