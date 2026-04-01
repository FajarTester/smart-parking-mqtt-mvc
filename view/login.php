<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Smart Parking</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        @import url('./style/style.login.css');
    </style>
</head>

<body>

    <div class="background-circle circle-1"></div>
    <div class="background-circle circle-2"></div>

    <div class="login-container">
        <div class="login-card">

            <div class="logo">
                🚗
            </div>

            <h2>Smart Parking</h2>
            <p>Silahkan login untuk mengakses dashboard parkir</p>

            <form method="POST" action="../controller/LoginController.php">

                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Masukkan username" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan password" minlength="8" required>
                </div>

                <button type="submit" class="login-btn">Login</button>

            </form>

            <div class="footer-text">
                Smart Parking System © 2026
            </div>

        </div>
    </div>

</body>

</html>