<?php

class ProfileController {
    private $userRepo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        $this->userRepo = new UserRepository();
    }

    public function update() {
        $userId = $_SESSION['user_id'];
        $user = $this->userRepo->findById($userId);
        
        if (!$user) {
            http_response_code(404);
            echo "Usuário não encontrado.";
            return;
        }

        $dataToUpdate = [];
        
        if (isset($_POST['name'])) {
            $dataToUpdate['name'] = trim($_POST['name']);
            $_SESSION['user_name'] = $dataToUpdate['name'];
        }

        if (!empty(trim($_POST['username']))) {
            $newUsername = trim($_POST['username']);
            // Check if username is already taken by another user
            $existingUser = $this->userRepo->findByUsername($newUsername);
            if ($existingUser && $existingUser['id'] != $userId) {
                header('Location: /dashboard?error=username_taken');
                exit;
            }
            $dataToUpdate['username'] = $newUsername;
            $_SESSION['username'] = $dataToUpdate['username'];
        }

        if (!empty($_POST['password'])) {
            $dataToUpdate['password_hash'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        // Handle profile picture upload
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/assets/uploads/profiles/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileInfo = pathinfo($_FILES['profile_pic']['name']);
            $extension = strtolower($fileInfo['extension']);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($extension, $allowedExtensions)) {
                $newFilename = 'user_' . $userId . '_' . time() . '.' . $extension;
                $destination = $uploadDir . $newFilename;

                if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $destination)) {
                    // Delete old profile picture if exists
                    if (!empty($user['profile_pic'])) {
                        $oldFile = __DIR__ . '/../../public' . $user['profile_pic'];
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }
                    $dataToUpdate['profile_pic'] = '/assets/uploads/profiles/' . $newFilename;
                    $_SESSION['profile_pic'] = $dataToUpdate['profile_pic'];
                }
            }
        }

        if (!empty($dataToUpdate)) {
            $this->userRepo->update($userId, $dataToUpdate);
        }

        header('Location: /dashboard?success=profile_updated');
        exit;
    }
}
