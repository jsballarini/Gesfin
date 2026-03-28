<?php

require_once __DIR__ . '/Database.php';

class EntryRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findByCompetence($year, $month, $status = '', $search = '') {
        $sql = "
            SELECT e.*, c.name as category_name, c.type as category_type 
            FROM entries e
            JOIN categories c ON e.category_id = c.id
            WHERE e.competence_year = :year AND e.competence_month = :month
        ";
        
        $params = ['year' => $year, 'month' => $month];

        if ($status === 'paid' || $status === 'pending') {
            $sql .= " AND e.status = :status";
            $params['status'] = $status;
        }

        if (!empty($search)) {
            $sql .= " AND (e.description LIKE :search OR e.notes LIKE :search)";
            $params['search'] = '%' . $search . '%';
        }

        $sql .= " ORDER BY e.due_date ASC, e.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM entries WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO entries (
                category_id, recurrence_group_id, description, amount, due_date, 
                competence_year, competence_month, status, notes, 
                created_at, updated_at
            ) VALUES (
                :category_id, :recurrence_group_id, :description, :amount, :due_date, 
                :competence_year, :competence_month, :status, :notes, 
                NOW(), NOW()
            )
        ");
        
        return $stmt->execute([
            'category_id' => $data['category_id'],
            'recurrence_group_id' => $data['recurrence_group_id'] ?? null,
            'description' => $data['description'],
            'amount' => $data['amount'],
            'due_date' => $data['due_date'],
            'competence_year' => $data['competence_year'],
            'competence_month' => $data['competence_month'],
            'status' => $data['status'] ?? 'pending',
            'notes' => $data['notes'] ?? null
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE entries SET 
                category_id = :category_id,
                description = :description,
                amount = :amount,
                due_date = :due_date,
                competence_year = :competence_year,
                competence_month = :competence_month,
                status = :status,
                notes = :notes,
                updated_at = NOW()
            WHERE id = :id
        ");
        
        return $stmt->execute([
            'id' => $id,
            'category_id' => $data['category_id'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'due_date' => $data['due_date'],
            'competence_year' => $data['competence_year'],
            'competence_month' => $data['competence_month'],
            'status' => $data['status'] ?? 'pending',
            'notes' => $data['notes'] ?? null
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM entries WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function toggleStatus($id) {
        $entry = $this->findById($id);
        if (!$entry) return false;

        $newStatus = $entry['status'] === 'paid' ? 'pending' : 'paid';
        $stmt = $this->db->prepare("UPDATE entries SET status = :status, updated_at = NOW() WHERE id = :id");
        return $stmt->execute(['status' => $newStatus, 'id' => $id]);
    }
}