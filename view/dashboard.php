
<?php
session_start();
if(!isset($_SESSION['login'])){
header("Location: login.php");
}

include "../model/ParkirModel.php";
$data=getParkir();
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Smart Parking</title>
</head>
<body>

<h2>Dashboard Smart Parking</h2>

<a href="../controller/logout.php">Logout</a>

<h3>Data Parkir</h3>

<table border="1">
<tr>
<th>ID</th>
<th>RFID</th>
<th>Waktu Masuk</th>
<th>Waktu Keluar</th>
</tr>

<?php while($row=mysqli_fetch_assoc($data)){ ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['rfid']; ?></td>
<td><?php echo $row['waktu_masuk']; ?></td>
<td><?php echo $row['waktu_keluar']; ?></td>
</tr>

<?php } ?>

</table>

</body>
</html>
