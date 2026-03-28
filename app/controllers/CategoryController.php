<?php

require_once __DIR__ . '/../repositories/CategoryRepository.php';

class CategoryController {
    private $categoryRepo;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        $this->categoryRepo = new CategoryRepository();
    }

    public function index() {
        $categories = $this->categoryRepo->findAll();
        $contentView = __DIR__ . '/../views/categories/index.php';
        require_once __DIR__ . '/../views/layouts/main.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $type = $_POST['type'] ?? 'expense';
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            if (!empty($name) && in_array($type, ['income', 'expense'])) {
                $this->categoryRepo->create($name, $type, $isActive);
                $_SESSION['success'] = "Categoria criada com sucesso!";
            } else {
                $_SESSION['error'] = "Dados inválidos!";
            }
        }
        header('Location: /categories');
        exit;
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $name = $_POST['name'] ?? '';
            $type = $_POST['type'] ?? 'expense';
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            if ($id && !empty($name) && in_array($type, ['income', 'expense'])) {
                $this->categoryRepo->update($id, $name, $type, $isActive);
                $_SESSION['success'] = "Categoria atualizada com sucesso!";
            } else {
                $_SESSION['error'] = "Dados inválidos!";
            }
        }
        header('Location: /categories');
        exit;
    }
}