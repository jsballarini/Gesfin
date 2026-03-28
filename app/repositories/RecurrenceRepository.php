<?php

require_once __DIR__ . '/Database.php';

class RecurrenceRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createGroup($monthsGenerated) {
        $stmt = $this->db->prepare("
            INSERT INTO recurrence_groups (months_generated, created_at, updated_at) 
            VALUES (:months, NOW(), NOW())
        ");
        $stmt->execute(['months' => $monthsGenerated]);
        return $this->db->lastInsertId();
    }

    public function deleteFutureEntries($groupId, $fromDate) {
        $stmt = $this->db->prepare("
            DELETE FROM entries 
            WHERE recurrence_group_id = :group_id AND due_date >= :from_date
        ");
        return $stmt->execute([
            'group_id' => $groupId,
            'from_date' => $fromDate
        ]);
    }
}