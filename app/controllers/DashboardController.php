<?php

require_once __DIR__ . '/../repositories/DashboardRepository.php';
require_once __DIR__ . '/../repositories/EntryRepository.php';

class DashboardController {
    private $dashboardRepo;
    private $entryRepo;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        $this->dashboardRepo = new DashboardRepository();
        $this->entryRepo = new EntryRepository();
    }

    public function index() {
        $year = $_GET['year'] ?? date('Y');
        $month = $_GET['month'] ?? date('n');

        $stats = $this->dashboardRepo->getMonthlyStats($year, $month);
        
        // Pega os lançamentos resumidos para a lista do dashboard (limitando a 5)
        $recentEntries = $this->entryRepo->findByCompetence($year, $month);
        $recentEntries = array_slice($recentEntries, 0, 5);
        
        // Dados do gráfico (12 meses a partir do mês atual selecionado)
        $chartData = $this->dashboardRepo->getChartData($year, $month, 12);

        $contentView = __DIR__ . '/../views/dashboard/_content.php';
        require_once __DIR__ . '/../views/layouts/main.php';
    }
}