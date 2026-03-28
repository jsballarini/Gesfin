<?php

require_once __DIR__ . '/../repositories/EntryRepository.php';
require_once __DIR__ . '/../repositories/CategoryRepository.php';
require_once __DIR__ . '/../repositories/RecurrenceRepository.php';
require_once __DIR__ . '/../services/RecurrenceService.php';

class EntryController {
    private $entryRepo;
    private $categoryRepo;
    private $recurrenceService;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        $this->entryRepo = new EntryRepository();
        $this->categoryRepo = new CategoryRepository();
        $this->recurrenceService = new RecurrenceService($this->entryRepo, new RecurrenceRepository());
    }

    public function index() {
        // Pega o mês e ano atual ou da URL
        $year = $_GET['year'] ?? date('Y');
        $month = $_GET['month'] ?? date('n');
        
        $status = $_GET['status'] ?? '';
        $search = $_GET['search'] ?? '';

        $entries = $this->entryRepo->findByCompetence($year, $month, $status, $search);
        $categories = $this->categoryRepo->findAll(); // Para o select do modal
        
        // Apenas categorias ativas para o cadastro
        $activeCategories = array_filter($categories, function($c) { return $c['is_active'] == 1; });

        $contentView = __DIR__ . '/../views/entries/index.php';
        require_once __DIR__ . '/../views/layouts/main.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = $_POST['due_date'];
            $time = strtotime($date);
            $isRecurrent = isset($_POST['is_recurrent']) && $_POST['is_recurrent'] == '1';
            $recurrenceMonths = (int)($_POST['recurrence_months'] ?? 12);
            
            $data = [
                'description' => $_POST['description'],
                'category_id' => $_POST['category_id'],
                'amount' => (float)$_POST['amount'], // input type="number" already sends with dot
                'due_date' => $date,
                'competence_year' => date('Y', $time),
                'competence_month' => date('n', $time),
                'status' => $_POST['status'] ?? 'pending',
                'notes' => $_POST['notes'] ?? null
            ];

            if ($isRecurrent && $recurrenceMonths > 1) {
                if ($this->recurrenceService->generateRecurrence($data, $recurrenceMonths)) {
                    $_SESSION['success'] = "Série recorrente criada com sucesso!";
                } else {
                    $_SESSION['error'] = "Erro ao criar série recorrente.";
                }
            } else {
                if ($this->entryRepo->create($data)) {
                    $_SESSION['success'] = "Lançamento criado com sucesso!";
                } else {
                    $_SESSION['error'] = "Erro ao criar lançamento.";
                }
            }
        }
        
        $this->redirectBack();
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $date = $_POST['due_date'];
            $time = strtotime($date);
            
            $data = [
                'description' => $_POST['description'],
                'category_id' => $_POST['category_id'],
                'amount' => (float)$_POST['amount'],
                'due_date' => $date,
                'competence_year' => date('Y', $time),
                'competence_month' => date('n', $time),
                'status' => $_POST['status'] ?? 'pending',
                'notes' => $_POST['notes'] ?? null
            ];

            if ($this->entryRepo->update($id, $data)) {
                $_SESSION['success'] = "Lançamento atualizado com sucesso!";
            } else {
                $_SESSION['error'] = "Erro ao atualizar lançamento.";
            }
        }
        
        $this->redirectBack();
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            if ($this->entryRepo->delete($id)) {
                $_SESSION['success'] = "Lançamento excluído com sucesso!";
            } else {
                $_SESSION['error'] = "Erro ao excluir lançamento.";
            }
        }
        $this->redirectBack();
    }

    public function deleteFuture() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $entry = $this->entryRepo->findById($id);

            if ($entry && $entry['recurrence_group_id']) {
                $groupId = $entry['recurrence_group_id'];
                $fromDate = $entry['due_date'];
                
                if ($this->recurrenceService->deleteFutureEntries($groupId, $fromDate)) {
                    $_SESSION['success'] = "Lançamentos futuros excluídos com sucesso!";
                } else {
                    $_SESSION['error'] = "Erro ao excluir lançamentos futuros.";
                }
            } else {
                $_SESSION['error'] = "Lançamento não pertence a uma recorrência.";
            }
        }
        $this->redirectBack();
    }

    public function toggleStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $this->entryRepo->toggleStatus($id);
        }
        $this->redirectBack();
    }

    private function redirectBack() {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/entries';
        header("Location: $referer");
        exit;
    }
}