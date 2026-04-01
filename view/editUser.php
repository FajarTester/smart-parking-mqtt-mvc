<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once "../controller/UsersController.php";
$usersController = new UsersController();

$id = $_GET['id'] ?? null;
if (!$id)
    exit("ID user tidak ditemukan");

$user = $usersController->getUserById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $usersController->updateUser($id, $username, $password, $role);
    header("Location: dashboardAdmin.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial;
            background: #f0f2f5;
        }

        .form-container {
            width: 400px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background: #36b9cc;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background: #2c9faf;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Edit User</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" value="<?= $user['username']; ?>" required>
            <input type="text" name="password" placeholder="Password" value="<?= $user['password']; ?>" required>
            <select name="role" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="petugas" <?= $user['role'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                <option value="owner" <?= $user['role'] == 'owner' ? 'selected' : '' ?>>Owner</option>
            </select>
            <button type="submit">Update User</button>
        </form>
    </div>
</body>

</html>