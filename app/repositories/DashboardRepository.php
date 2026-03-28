<?php

require_once __DIR__ . '/Database.php';

class DashboardRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getMonthlyStats($year, $month) {
        // Busca todos os lançamentos do mês
        $stmt = $this->db->prepare("
            SELECT e.amount, e.status, c.type 
            FROM entries e
            JOIN categories c ON e.category_id = c.id
            WHERE e.competence_year = :year AND e.competence_month = :month
        ");
        $stmt->execute(['year' => $year, 'month' => $month]);
        $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stats = [
            'total_income' => 0,
            'total_expense' => 0,
            'realized_balance' => 0,
            'projected_balance' => 0
        ];

        foreach ($entries as $entry) {
            $amount = (float) $entry['amount'];
            
            if ($entry['type'] === 'income') {
                $stats['total_income'] += $amount;
                $stats['projected_balance'] += $amount;
                
                if ($entry['status'] === 'paid') {
                    $stats['realized_balance'] += $amount;
                }
            } else { // expense
                $stats['total_expense'] += $amount;
                $stats['projected_balance'] -= $amount;
                
                if ($entry['status'] === 'paid') {
                    $stats['realized_balance'] -= $amount;
                }
            }
        }

        return $stats;
    }

    public function getChartData($startYear, $startMonth, $monthsAhead = 12) {
        $data = [];
        $currentYear = $startYear;
        $currentMonth = $startMonth;

        for ($i = 0; $i < $monthsAhead; $i++) {
            $monthStr = str_pad($currentMonth, 2, '0', STR_PAD_LEFT);
            $key = "{$monthStr}/{$currentYear}";
            
            $stats = $this->getMonthlyStats($currentYear, $currentMonth);
            
            $data['labels'][] = $key;
            $data['projected'][] = $stats['projected_balance'];
            $data['realized'][] = $stats['realized_balance'];

            $currentMonth++;
            if ($currentMonth > 12) {
                $currentMonth = 1;
                $currentYear++;
            }
        }

        return $data;
    }
}