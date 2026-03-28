<?php

require_once __DIR__ . '/Database.php';

class CategoryRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $type, $isActive) {
        $stmt = $this->db->prepare("INSERT INTO categories (name, type, is_active, created_at, updated_at) VALUES (:name, :type, :is_active, NOW(), NOW())");
        return $stmt->execute([
            'name' => $name,
            'type' => $type,
            'is_active' => $isActive
        ]);
    }

    public function update($id, $name, $type, $isActive) {
        $stmt = $this->db->prepare("UPDATE categories SET name = :name, type = :type, is_active = :is_active, updated_at = NOW() WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'type' => $type,
            'is_active' => $isActive
        ]);
    }

    public function inactivate($id) {
        $stmt = $this->db->prepare("UPDATE categories SET is_active = 0, updated_at = NOW() WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}