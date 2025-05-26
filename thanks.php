<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Terima kasih</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background-image: url('view asrama.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      color: #fff;
      margin: 0;
      text-align: center;
      padding: 50px 20px;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.8);
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
      max-width: 500px;
      width: 100%;
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h1 {
      color: #d35400;
      font-weight: bold;
      font-size: 2rem;
    }

    p {
      color: #333;
      font-size: 18px;
      margin: 20px 0;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      font-size: 16px;
      font-weight: bold;
      text-align: center;
      text-decoration: none;
      color: #fff;
      background-color: #d35400;
      border-radius: 5px;
      transition: background-color 0.3s, transform 0.2s;
    }

    .btn:hover {
      background-color: #e67e22;
      transform: scale(1.05);
    }

    footer {
      margin-top: 50px;
      font-size: 0.9rem;
      color: #C9C0BB;
      position: relative;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>✔️ Terima kasih!</h1>
    <p>⏳ Aduan anda telah diterima. Mohon tunggu sebentar untuk pihak warden/penyelia asrama melihat aduan anda.</p>
    <a href="index.php" class="btn">Kembali</a>
  </div>
</body>
</html>
