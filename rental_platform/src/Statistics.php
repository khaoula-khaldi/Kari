<?php

class Statistics {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getTotalUsers(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM users");
        return (int) $stmt->fetchColumn();
    }

   
    public function getTotalRentals(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM rentals");
        return (int) $stmt->fetchColumn();
    }

    public function getTotalBookings(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM reservations");
        return (int) $stmt->fetchColumn();
    }

    public function getTotalRevenue(): float {
        $stmt = $this->pdo->prepare("
            SELECT IFNULL(SUM(total_price), 0)
            FROM reservations
            WHERE status = 'confirmed'
        ");
        return (float) $stmt->fetchColumn();
    }

    // public function getTopRentals(int $limit = 10): array {
    //     $stmt = $this->pdo->prepare("
    //         SELECT 
    //             rentals.id,
    //             rentals.title,
    //             SUM(reservations.total_price) AS revenue
    //         FROM reservations
    //         JOIN rentals ON reservations.rental_id = rentals.id
    //         WHERE reservations.status = 'confirmed'
    //         GROUP BY rentals.id
    //         ORDER BY revenue DESC
    //         LIMIT ?
    //     ");

    //     $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    //     $stmt->execute();

    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
    
}
