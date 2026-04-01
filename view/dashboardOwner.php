<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'owner') {
    header("Location: login.php");
    exit();
}

require_once "../model/ParkirOwnerModel.php";
$parkirOwner = new ParkirOwnerModel();

$allDone = $parkirOwner->getAllDone();
$totalFee = $parkirOwner->getTotalFee();
$feeByJenis = $parkirOwner->getFeeByJenis();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            color: #333;
        }

        header {
            background: #1cc88a;
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
            color: #1cc88a;
        }

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
        <h1>Dashboard Owner</h1>
        <a href="../controller/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </header>

    <div class="container">
        <div class="cards">
            <div class="card">
                <h3>Total Transaksi Selesai</h3>
                <p>
                    <?= count($allDone) ?>
                </p>
            </div>
            <div class="card">
                <h3>Total Pendapatan</h3>
                <p>Rp
                    <?= number_format($totalFee, 0, ',', '.') ?>
                </p>
            </div>
            <?php foreach ($feeByJenis as $jenis => $total): ?>
                <div class="card">
                    <h3>Total
                        <?= ucfirst($jenis) ?>
                    </h3>
                    <p>Rp
                        <?= number_format($total, 0, ',', '.') ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="overflow-x:auto; animation: fadeInUp 0.8s ease;">
            <h2>Detail Transaksi</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>RFID</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Durasi (menit)</th>
                    <th>Fee</th>
                    <th>Jenis</th>
                </tr>
                <?php foreach ($allDone as $p): ?>
                    <tr>
                        <td>
                            <?= $p['id'] ?>
                        </td>
                        <td>
                            <?= $p['card_id'] ?>
                        </td>
                        <td>
                            <?= $p['checkin_time'] ?>
                        </td>
                        <td>
                            <?= $p['checkout_time'] ?>
                        </td>
                        <td>
                            <?= $p['duration'] ?>
                        </td>
                        <td>Rp
                            <?= number_format($p['fee'], 0, ',', '.') ?>
                        </td>
                        <td>
                            <?= $p['jenis'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

    </div>
</body>

</html>