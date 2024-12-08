<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(to bottom, #ff7e5f, #feb47b);
            font-family: Arial, sans-serif;
        }
        .login-container {
            background: linear-gradient(to bottom, #8B0000, #800000);
            border-radius: 15px;
            padding: 20px;
            width: 300px;
            text-align: center;
            color: white;
        }
        .login-container h1 {
            margin: 0;
            font-size: 24px;
        }
        .login-container h2 {
            margin: 20px 0;
            color: #d4af37;
            font-size: 20px;
        }
        .input-group {
            display: flex;
            align-items: center;
            margin: 10px 0;
            background: #d3d3d3;
            border-radius: 25px;
            padding: 5px 10px;
        }
        .input-group i {
            color: #8B0000;
        }
        .input-group input {
            border: none;
            background: none;
            outline: none;
            padding: 10px;
            flex: 1;
            border-radius: 25px;
        }
        .login-button {
            background: white;
            color: #8B0000;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
            text-decoration: none;
        }
        .login-button i {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>SELAMAT DATANG</h1>
        <h2>Login</h2>
        <?php
        $errorMessage = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $phone = $_POST['phone'];

            if (!preg_match('/^[A-Za-z]+$/', $username)) {
                $errorMessage = 'Username harus hanya mengandung huruf.';
            } elseif (!preg_match('/^\d{10,}$/', $phone)) {
                $errorMessage = 'Nomor telepon harus memiliki setidaknya 10 digit.';
            } else {
                // Simpan data di session atau database
                session_start();
                $_SESSION['username'] = $username;
                header('Location: nextpage.php'); // Redirect ke halaman berikutnya
                exit();
            }
        }
        ?>
        <?php if ($errorMessage): ?>
            <p style="color: yellow;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="text" name="phone" placeholder="Phone" required>
            </div>
            <button type="submit" class="login-button">
                Login <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>
</body>
</html>
