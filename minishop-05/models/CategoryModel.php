<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

class CategoryModel
{
    private ?PDO $db = null;

    public function __construct()
    {
        try {
            $this->db = Database::getConnection();
            $this->initTable();
        } catch (Throwable $e) {
            $this->db = null;
        }
    }

    private function initTable(): void
    {
        if ($this->db === null) {
            return;
        }

        $sql = "CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
        $this->db->exec($sql);
    }

    public function all(): array
    {
        if ($this->db === null) {
            return [];
        }

        $stmt = $this->db->query("SELECT * FROM categories ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function find(int $id): ?array
    {
        if ($this->db === null) {
            return null;
        }

        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: null;
    }

    public function create(string $name, ?string $description = null): int
    {
        if ($this->db === null) {
            return 0;
        }

        $stmt = $this->db->prepare("INSERT INTO categories (name, description) VALUES (:name, :description)");
        $stmt->execute([
            'name' => $name,
            'description' => $description,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, string $name, ?string $description = null): bool
    {
        if ($this->db === null) {
            return false;
        }

        $stmt = $this->db->prepare("UPDATE categories SET name = :name, description = :description WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description,
        ]);
    }

    public function delete(int $id): bool
    {
        if ($this->db === null) {
            return false;
        }

        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
