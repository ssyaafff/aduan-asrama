<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error_message = "Nama Penuh dan Kata Laluan diperlukan.";
    } else {
        $sql = "INSERT INTO user (username, password) VALUES (?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss", $username, $password);
            if ($stmt->execute()) {
                $success_message = "Pendaftaran berjaya untuk Nama: $username!";
            } else {
                $error_message = "Ralat semasa pendaftaran: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error_message = "Ralat SQL: " . $mysqli->error;
        }
    }
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-color: rgba(255, 255, 255, 0.95);
            --text-color: #333;
            --input-bg: #fff;
            --button-bg: #2ecc71;
            --button-text: #fff;
            --border-color: #ccc;
        }

        body.dark {
            --bg-color: rgba(0, 0, 0, 0.85);
            --text-color: #f1f1f1;
            --input-bg: #333;
            --button-bg: #27ae60;
            --button-text: #fff;
            --border-color: #555;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('view asrama.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            transition: background-color 0.4s ease, color 0.4s ease;
        }

        body::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            background: var(--bg-color);
            padding: 30px 25px;
            border-radius: 15px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: fadeInUp 0.8s ease-out;
        }

        .theme-toggle {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 18px;
            cursor: pointer;
            background-color: transparent;
            color: var(--text-color);
            padding: 8px;
            border-radius: 50%;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .theme-toggle:hover {
            background-color: rgba(0,0,0,0.1);
        }

        .logo img {
            width: 100px;
            margin-bottom: 10px;
        }

        h2 {
            color: var(--text-color);
            margin-bottom: 20px;
        }

        form {
            text-align: left;
        }

        label {
            color: var(--text-color);
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background: var(--input-bg);
            color: var(--text-color);
            transition: background-color 0.4s ease, color 0.4s ease, border-color 0.4s ease;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: var(--button-bg);
            color: var(--button-text);
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.4s ease;
        }

        button:hover {
            background-color: #27ae60;
        }

        .success, .error {
            margin-bottom: 15px;
            text-align: center;
            font-weight: bold;
        }

        .success { color: green; }
        .error { color: red; }

        .login-link, .back-link {
            text-align: center;
            margin-top: 10 px;
        }

        .login-link a, .back-link a {
            text-decoration: none;
            font-weight: bold;
            color: #3498db;
        }

        .login-link a:hover, .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="theme-toggle" onclick="toggleTheme()">
            <i class="fas fa-moon"></i>
        </div>

        <div class="logo">
            <img src="logokvsepang.jpg" alt="Logo">
        </div>

        <h2><i class="fas fa-user-plus"></i> Daftar Pengguna</h2>

        <?php if (isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
            <div class="login-link">
                <p>Sudah ada akaun? <a href="login.php"><i class="fas fa-sign-in-alt"></i> Log Masuk</a></p>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="username"><i class="fas fa-user"></i> Nama Penuh:</label>
            <input type="text" id="username" name="username" placeholder="NAMA PENGGUNA" required>

            <label for="password"><i class="fas fa-lock"></i> Kata Laluan:</label>
            <input type="password" id="password" name="password" placeholder="KATA LALUAN" required>

            <button type="submit"><i class="fas fa-user-check"></i> Daftar</button>
        </form>

        <div class="login-link">
            <br>
            <a href="login.php"><i class="fas fa-sign-in-alt"></i> Sudah ada akaun? Log Masuk</a>
        </div>
        <div class="back-link">
            <br>
            <a href="index.php"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <script>
        function toggleTheme() {
            document.body.classList.toggle('dark');
            const icon = document.querySelector('.theme-toggle i');
            setTimeout(() => {
                icon.classList.toggle('fa-sun');
                icon.classList.toggle('fa-moon');
            }, 150);
        }
    </script>
</body>
</html>