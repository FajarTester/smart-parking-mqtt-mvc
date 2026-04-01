<?php
require_once "../controller/ParkirController.php";
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$parkirController = new ParkirController();
$data_in = $parkirController->getParkirByStatus('IN');
$data_out = $parkirController->getParkirByStatus('OUT');
$data_done = $parkirController->getParkirByStatus('DONE');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Smart Parking</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        @import url('./style/style.dashboard.css');
    </style>
</head>

<body>

    <div class="container">

        <div class="header">
            <div>
                <h1>🚗 Dashboard Smart Parking</h1>
                <p>Monitoring kendaraan masuk, keluar, dan riwayat parkir secara realtime</p>
            </div>
            <a href="../controller/logout.php" class="logout-btn">Logout</a>
        </div>

        <div class="stats">
            <div class="card">
                <h3>Kendaraan Masuk</h3>
                <div class="number"><?= mysqli_num_rows($data_in); ?></div>
            </div>

            <div class="card">
                <h3>Menunggu Keluar</h3>
                <div class="number"><?= mysqli_num_rows($data_out); ?></div>
            </div>

            <div class="card">
                <h3>Riwayat Selesai</h3>
                <div class="number"><?= mysqli_num_rows($data_done); ?></div>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <h2>Kendaraan Masuk</h2>
                <span class="badge badge-in">IN</span>
            </div>

            <div class="table-wrapper">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>RFID</th>
                        <th>Waktu Masuk</th>
                        <th>Status</th>
                    </tr>

                    <?php mysqli_data_seek($data_in, 0); ?>
                    <?php while ($row = mysqli_fetch_assoc($data_in)): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['card_id']; ?></td>
                            <td><?= $row['checkin_time']; ?></td>
                            <td><?= $row['status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <h2>Pembayaran & Keluar</h2>
                <span class="badge badge-out">OUT</span>
            </div>

            <p class="note">Silahkan proses pembayaran manual, lalu klik tombol untuk membuka palang.</p>

            <div class="table-wrapper">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>RFID</th>
                        <th>Waktu Keluar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>

                    <?php mysqli_data_seek($data_out, 0); ?>
                    <?php while ($row = mysqli_fetch_assoc($data_out)): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['card_id']; ?></td>
                            <td><?= $row['checkout_time']; ?></td>
                            <td><?= $row['status']; ?></td>
                            <td>
                                <a href="../controller/ProsesController.php?id=<?= $row['id']; ?>" class="btn-buka"
                                    onclick="return confirm('Konfirmasi pembayaran manual selesai & buka palang?')">
                                    Buka Palang
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <h2>Riwayat Selesai</h2>
                <span class="badge badge-done">DONE</span>
            </div>

            <div class="table-wrapper">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>RFID</th>
                        <th>Waktu Masuk</th>
                        <th>Waktu Keluar</th>
                        <th>Status</th>
                    </tr>

                    <?php mysqli_data_seek($data_done, 0); ?>
                    <?php while ($row = mysqli_fetch_assoc($data_done)): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['card_id']; ?></td>
                            <td><?= $row['checkin_time']; ?></td>
                            <td><?= $row['checkout_time']; ?></td>
                            <td><?= $row['status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>

    </div>

</body>

</html>
```