
<?php
include "../koneksi.php";

function loginUser($username,$password){
global $conn;

$q="SELECT * FROM user WHERE username='$username' AND password='$password'";
$r=mysqli_query($conn,$q);

return mysqli_num_rows($r);
}
?>
