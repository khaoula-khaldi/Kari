<?php
require_once __DIR__."/../config/config.php";
session_start();

class Review {
    private int $id;
    private int $rental_id;
    private int $user_id;
    private int $rating;
    private string $comment;
    private string $created_at;
    private PDO $pdo;

    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Ajouter une review
    public function create(int $user_id, int $rental_id, int $rating, string $comment): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO reviews (user_id, rental_id, rating, comment)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$user_id, $rental_id, $rating, $comment]);
    }

    // Modifier une review (par user)
    public function update(int $review_id, int $rating, string $comment): bool {
        $stmt = $this->pdo->prepare("
            UPDATE reviews
            SET rating = ?, comment = ?
            WHERE id = ?
        ");
        return $stmt->execute([$rating, $comment, $review_id]);
    }

    // Supprimer une review (par user ou admin)
    public function delete(int $review_id): bool {
        $stmt = $this->pdo->prepare("
            DELETE FROM reviews WHERE id = ?
        ");
        return $stmt->execute([$review_id]);
    }

    // Récupérer toutes les reviews pour un logement
    public function getByRental(int $rental_id): array {
        $stmt = $this->pdo->prepare("
            SELECT reviews.*, users.name, users.email
            FROM reviews
            JOIN users ON reviews.user_id = users.id
            WHERE rental_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$rental_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une review par ID
    public function getById(int $review_id): array|false {
        $stmt = $this->pdo->prepare("
            SELECT * FROM reviews WHERE id = ?
        ");
        $stmt->execute([$review_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Moyenne des notes pour un logement
    public function getAverageRating(int $rental_id): float {
        $stmt = $this->pdo->prepare("
            SELECT IFNULL(AVG(rating),0) AS avg_rating
            FROM reviews
            WHERE rental_id = ?
        ");
        $stmt->execute([$rental_id]);
        return (float) $stmt->fetchColumn();
    }
}
