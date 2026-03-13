
<?php
session_start();
include "../model/UserModel.php";

$username=$_POST['username'];
$password=$_POST['password'];

if(strlen($password)<8){
echo "Password minimal 8 karakter";
exit;
}

$cek=loginUser($username,$password);

if($cek>0){
$_SESSION['login']=true;
header("Location:../view/dashboard.php");
}else{
echo "Login gagal";
}
?>
