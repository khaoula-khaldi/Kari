<?php 
 class Favorie{
    private int $id;
    private int $user_id;
    private int $rental_id;
    private PDO $pdo;

    public function __construct($pdo){
        $this->pdo=$pdo;
    }

    public function add($user_id,$rental_id){
        $stmt=$this->pdo->prepare("INSERT INTO favoris(user_id,rental_id) VALUES(?,?)" );
        return $stmt->execute([$user_id,$rental_id]);
    }

    public function remove($user_id,$rental_id){
        $stmt=$this->pdo->prepare("DELETE * FROM favoris WHERE user_id = ? AND rental_id = ?");
        return $stmt->execute([$user_id,$rental_id]);
    }

    public function findUserFavorites(int $user_id): array{
        $sql = "
            SELECT 
                r.id AS rental_id,
                r.title,
                r.city,
                r.price_per_night,
                r.capacity,
                r.image_url,
                u.id AS user_id,
                u.name AS user_name
            FROM favoris f
            INNER JOIN rentals r ON r.id = f.rental_id
            INNER JOIN users u ON u.id = f.user_id
            ORDER BY f.id DESC

        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function annelerFavorise($id):bool{
        $stmt=$this->pdo->prepare("DELETE FROM favoris WHERE id=?");
        return $stmt->execute([$id]);
    }

    


 }

?>