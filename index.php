<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asrama Kolej Vokasional Sepang</title>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            text-align: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('view asrama.jpg') no-repeat center center/cover;
            opacity: 0.7;
            backdrop-filter: blur(5px); /* Increased blur effect */
            z-index: 1;
        }

        .dark-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6); /* Darker overlay */
            z-index: 1;
        }

        .container {
            width: 90%;
            max-width: 450px; /* Increased max-width for better layout */
            padding: 25px; /* Increased padding */
            background-color: rgba(255, 255, 255, 0.95); /* Slightly more opaque */
            border-radius: 10px; /* More rounded corners */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Enhanced shadow */
            position: relative;
            z-index: 2;
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            width: 120px; /* Increased logo size */
            margin-bottom: 20px; /* Increased margin */
        }

        h1 {
            font-size: 24px; /* Increased font size */
            color: #333;
        }

        p {
            font-size: 16px; /* Increased font size */
            color: #666;
        }

        .button {
            display: inline-block;
            margin: 15px 0; /* Increased margin */
            padding: 12px 25px; /* Increased padding */
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
        }

        .button i {
            margin-right: 8px;
        }

        .button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Enhanced shadow on hover */
        }

        @media (max-width: 480px) {
            .container {
                width: 95%;
                padding: 20px; /* Adjusted padding */
            }
            h1 {
                font-size: 20px; /* Adjusted font size */
            }
            p {
                font-size: 14px; /* Adjusted font size */
            }
            .button {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="dark-overlay"></div>

<div class="container">
    <img src="logokvsepang.jpg" alt="Logo" class="logo">
    <h1>Selamat Datang ke e-Aduan Asrama Kolej Vokasional Sepang</h1>
    <p>Sila log masuk atau daftar terlebih dahulu</p>
    <p>Anda juga boleh menyemak aduan anda tanpa perlu log masuk atau daftar</p>

    <a href="login.php" class="button"><i class="fas fa-sign-in-alt"></i> Log Masuk</a><br>
    <a href=" signup.php" class="button"><i class="fas fa-user-plus"></i> Daftar</a><br>
    <a href="semakaduan.php" class="button"><i class="fas fa-search"></i> Semak Aduan</a>
</div>

</body>
</html>