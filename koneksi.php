
<?php
$host="localhost";
$user="root";
$pass="";
$db="smart_parkir";

$conn=mysqli_connect($host,$user,$pass,$db);

if(!$conn){
die("Koneksi gagal");
}
?>
