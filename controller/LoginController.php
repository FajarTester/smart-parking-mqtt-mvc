<?php
session_start();

require_once "../model/AuthModel.php";

class AuthController
{
    private $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function login($username, $password)
    {
        $user = $this->authModel->loginUser($username);

        if ($user) {
            if ($password === $user['password']) {
                $_SESSION['login'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];


                $redirect = [
                    'admin' => '../view/dashboardAdmin.php',
                    'petugas' => '../view/dashboardPetugas.php',
                    'owner' => '../view/dashboardOwner.php'
                ];

                if (isset($redirect[$user['role']])) {
                    header("Location: " . $redirect[$user['role']]);
                    exit();
                }

                return "Role tidak dikenali";
            } else {
                return "Password salah";
            }
        }

        return "Username tidak ditemukan";
    }
}

$authController = new AuthController();

$username = $_POST['username'];
$password = $_POST['password'];

$error = $authController->login($username, $password);

if ($error) {
    echo $error;
}
?>