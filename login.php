<?php
include ('config.php');

session_start();

$error_message = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($mysqli, $_POST["username"]);
    $password = mysqli_real_escape_string($mysqli, $_POST["password"]);

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM user WHERE username=? AND password=?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password); // "ss" for two string parameters

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_array($result);

    if ($row) {
        if ($row["usertype"] == "user") {
            $_SESSION["username"] = $username;
            header("Location: add.php");
            exit();
        } elseif ($row["usertype"] == "admin") {
            $_SESSION["username"] = $username;
            header("Location: adminhomepage.php");
            exit();
        } elseif ($row["usertype"] == "warden") {
            $_SESSION["username"] = $username;
            header("Location: homepage.php");
            exit();
        }
    } else {
        $error_message = "Nama atau Kata Laluan anda salah!";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --bg-color: #ffffffee;
            --text-color: #333;
            --input-bg: #fff;
            --input-border: #ccc;
            --btn-bg: #4CAF50;
            --btn-hover: #43a047;
            --link-color: #007BFF;
            --link-hover: #0056b3;
        }

        body.dark {
            --bg-color: #1e1e1e;
            --text-color: #f1f1f1;
            --input-bg: #2b2b2b;
            --input-border: #555;
            --btn-bg: #66bb6a;
            --btn-hover: #57a05c;
            --link-color: #66ccff;
            --link-hover: #33bbff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('view asrama.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            transition: background 0.3s;
        }

        .form-container {
            background-color: var(--bg-color);
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 1s ease;
            color: var(--text-color);
            transition: background-color 0.3s, color 0.3s;
            position: relative;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .form-title {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .form-container img {
            max-width: 100px;
            margin-bottom: 20px;
        }

        .input-container {
            position: relative;
            margin-bottom: 20px;
        }

        .form-input {
            width: 100%;
            padding: 12px 45px 12px 40px;
            border: 1px solid var(--input-border);
            border-radius: 8px;
            font-size: 16px;
            background-color: var(--input-bg);
            color: var(--text-color);
            transition: 0.3s;
        }

        .form-input:focus {
            border-color: #4CAF50;
            outline: none;
            background-color: #f9fff9;
        }

        body.dark .form-input:focus {
            background-color: #2f4f2f;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: #888;
            font-size: 18px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            font-size: 18px;
        }

        .form-submit {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            background-color: var(--btn-bg);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .form-submit:hover {
            background-color: var(--btn-hover);
            transform: scale(1.03);
        }

        .back-link {
            margin-top: 20px;
        }

        .back-link a {
            color: var(--link-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .back-link a:hover {
            color: var(--link-hover);
            text-decoration: underline;
        }

        .error-message {
            color: red;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .theme-toggle {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: var(--text-color);
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <form action="#" method="POST">
        <div class="form-container">
            <button type="button" class="theme-toggle" id="themeToggle" title="Change Theme">
                <i class="fas fa-moon"></i>
            </button>
            <img src="logokvsepang.jpg" alt="Logo">
            <div class="form-title">Log Masuk</div>
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <div class="input-container">
                <i class="fas fa-id-card input-icon"></i>
                <input type="text" class="form-input" name="username" placeholder="NAMA PENGGUNA" required>
            </div>
            <div class="input-container">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" class="form-input" name="password" id="password" placeholder="KATA LALUAN" required>
                <i class="fas fa-eye toggle-password" id="togglePassword"></i>
            </div>
            <input type="submit" value="LOG MASUK" class="form-submit" name="login">
            <div class="back-link">
            <a href="index.php"><i class="fas fa-arrow-left"></i> KEMBALI </a>
            </div>
        </div>
    </form>

    <script>
        // Show/Hide Password
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Dark Mode Toggle
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;

        // Apply saved theme on load
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark');
            themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        }

        themeToggle.addEventListener('click', () => {
            body.classList.toggle('dark');
            const isDark = body.classList.contains('dark');
            themeToggle.innerHTML = isDark ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
    </script>
</body>
</html>