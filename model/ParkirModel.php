
<?php
include "../koneksi.php";

function getParkir(){
global $conn;

$q="SELECT * FROM parkir ORDER BY waktu_masuk DESC";
return mysqli_query($conn,$q);
}
?>
