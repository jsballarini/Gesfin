<?php

require_once __DIR__ . '/../repositories/UserRepository.php';

class AuthController {
    private $userRepo;

    public function __construct() {
        $this->userRepo = new UserRepository();
    }

    public function index() {
        // Se já estiver logado, redireciona pro dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit;
        }
        
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userRepo->findByUsername($username);

        if ($user && password_verify($password, $user['password_hash'])) {
            // Sucesso no login
            session_regenerate_id(true); // Previne Session Fixation
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            header('Location: /dashboard');
            exit;
        }

        // Falha no login
        $_SESSION['error'] = 'Usuário ou senha inválidos.';
        header('Location: /login');
        exit;
    }

    public function logout() {
        session_destroy();
        header('Location: /login');
        exit;
    }
}