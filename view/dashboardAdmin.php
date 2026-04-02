<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once "../controller/UsersController.php";
$usersController = new UsersController();
$users = $usersController->getUserAll();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f8;
            color: #333;
        }

        header {
            background: #46A085;
            color: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.6s ease;
        }

        header h1 {
            font-size: 1.8rem;
        }

        header a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        header a:hover {
            opacity: 0.8;
        }

        .container {
            width: 95%;
            max-width: 1200px;
            margin: 30px auto;
        }

        /* Cards */
        .cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            flex: 1;
            min-width: 200px;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
            animation: fadeInUp 0.6s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .card h3 {
            font-size: 1rem;
            color: #555;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 1.5rem;
            font-weight: bold;
            color: #46A085;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        th,
        td {
            padding: 15px 10px;
            text-align: left;
        }

        th {
            background: #f8f9fc;
            color: #555;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background: #f4f6f8;
        }

        tr:hover {
            background: #e9ecef;
            transition: 0.3s;
        }

        /* Buttons */
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            color: #fff;
            cursor: pointer;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-add {
            background: #1cc88a;
        }

        .btn-add:hover {
            background: #17a673;
        }

        .btn-edit {
            background: #46A085;
        }

        .btn-edit:hover {
            background: #46A085;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media(max-width:768px) {
            .cards {
                flex-direction: column;
            }

            header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    <header>
        <h1>Dashboard Admin</h1>
        <a href="../controller/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </header>

    <div class="container">

        <!-- Cards (Statistik contoh) -->
        <div class="cards">
            <div class="card">
                <h3>Total User</h3>
                <p><?= count($users) ?></p>
            </div>
            <div class="card">
                <h3>Admin</h3>
                <p><?= count(array_filter($users, fn($u) => $u['role'] == 'admin')) ?></p>
            </div>
            <div class="card">
                <h3>Petugas</h3>
                <p><?= count(array_filter($users, fn($u) => $u['role'] == 'petugas')) ?></p>
            </div>
            <div class="card">
                <h3>Owner</h3>
                <p><?= count(array_filter($users, fn($u) => $u['role'] == 'owner')) ?></p>
            </div>
        </div>

        <!-- Tabel Users -->
        <div style="overflow-x:auto; animation: fadeInUp 0.8s ease;">
            <a href="addUser.php" class="btn btn-add" style="margin-bottom:15px; display:inline-block;"><i
                    class="fa fa-plus"></i> Tambah User</a>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['role'] ?></td>
                        <td>
                            <a href="editUser.php?id=<?= $user['id'] ?>" class="btn btn-edit"><i class="fa fa-edit"></i>
                                Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

    </div>

</body>

</html>