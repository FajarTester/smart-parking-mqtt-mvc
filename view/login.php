
<!DOCTYPE html>
<html>
<head>
<title>Login Smart Parking</title>
</head>
<body>

<h2>Login</h2>

<form method="POST" action="../controller/LoginController.php">

Username<br>
<input type="text" name="username" required><br><br>

Password<br>
<input type="password" name="password" minlength="8" required><br><br>

<button type="submit">Login</button>

</form>

</body>
</html>
