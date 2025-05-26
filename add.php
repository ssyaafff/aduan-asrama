<?php
include 'config.php';

if (isset($_POST['hantar'])) {
    // Dapatkan data daripada borang
    $no_dorm = $_POST['no_dorm'];
    $nama_pelajar = $_POST['nama_pelajar'];
    $notel_pelajar = $_POST['notel_pelajar'];
    $email_pelajar = $_POST['email_pelajar'];
    $kategori = $_POST['kategori'];
    $keterangan = $_POST['keterangan'];

    // Semak sama ada fail dimuat naik
    $file_name = $_FILES['gambar']['name'];
    $file_tmp = $_FILES['gambar']['tmp_name'];
    $upload_dir = "uploads/";

    // Pastikan folder 'uploads/' wujud
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Buat folder jika tiada
    }

    // Hasilkan nama unik untuk fail
    $new_file_name = time() . "_" . basename($file_name); 
    $uploaded_file = $upload_dir . $new_file_name;

    // Muat naik fail
    if (!empty($file_name)) {
        if (move_uploaded_file($file_tmp, $uploaded_file)) {
            echo "Fail berjaya dimuat naik!<br>";
        } else {
            echo "Ralat semasa memuat naik fail.<br>";
        }
    } else {
        $new_file_name = ""; // Tiada gambar dimuat naik
    }

    // Sediakan penyataan SQL
    $stmt = $mysqli->prepare("INSERT INTO senarai_aduan (no_dorm, nama_pelajar, notel_pelajar, email_pelajar, kategori, keterangan, gambar) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $no_dorm, $nama_pelajar, $notel_pelajar, $email_pelajar, $kategori, $keterangan, $new_file_name);

    // Laksanakan penyataan SQL
    if ($stmt->execute()) {
        // Arahkan ke halaman terimakasih.php selepas berjaya
        header("Location: thanks.php");
        exit();
    } else {
        echo "Error: " . $stmt->error; // Paparkan mesej ralat jika berlaku
    }
    
    // Tutup penyataan
    $stmt->close();
}
// Tutup sambungan pangkalan data
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membuat Aduan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-image: url('view asrama.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 25px 30px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #004AAD;
        }

        form {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        input[type="text"],
        textarea,
        select,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus,
        textarea:focus,
        select:focus,
        input[type="file"]:focus {
            border-color: #0072ff;
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        input[type="submit"],
        .back-button {
            background-color: #0072ff;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        input[type="submit"]:hover,
        .back-button:hover {
            transform: scale(1.05);
        }

        input[type="submit"]:hover {
            background-color: #28a745;
        }

        .back-button {
            background-color: #dc3545;
            margin-top: 10px;
        }

        .back-button:hover {
            background-color: #c82333;
        }

        /* Preview Gambar */
        #image-preview {
            display: none;
            margin-top: 10px;
            max-width: 100%;
            max-height: 200px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
    </style>
    <script>
        function previewImage(event) {
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                var imgElement = document.getElementById('image-preview');
                imgElement.src = e.target.result;
                imgElement.style.display = 'block';  // Menunjukkan imej
            };
            reader.readAsDataURL(file);
        }
    </script>
</head>
<body>
    <div class="form-container">
        <h2>e-Aduan Asrama KV Sepang</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="no_dorm">No. Dorm</label>
                <input type="text" name="no_dorm" required>
            </div>
            <div>
                <label for="nama_pelajar">Nama Pelajar</label>
                <input type="text" name="nama_pelajar" required>
            </div>
            <div>
                <label for="notel_pelajar">No. Telefon Pelajar</label>
                <input type="text" name="notel_pelajar" required>
            </div>
            <div>
                <label for="email_pelajar">Email Pelajar</label>
                <input type="text" name="email_pelajar" required>
            </div>
            <div>
                <label for="kategori">Jenis Kategori</label>
                <select name="kategori" required>
                    <option value="">--Pilih Kategori--</option>
                    <option value="Fasiliti">Fasiliti</option>
                    <option value="Elektrikal">Elektrikal</option>
                    <option value="Perabot">Perabot</option>
                </select>
            </div>
            <div>
                <label for="keterangan">Keterangan</label>
                <textarea name="keterangan" required></textarea>
            </div>
            <div>
                <label for="gambar">Gambar</label>
                <input type="file" name="gambar" accept="image/*" onchange="previewImage(event)" required>
                <img id="image-preview" src="#" alt="Preview Gambar">
            </div>
            <input type="submit" name="hantar" value="Hantar">
        </form>
        <button class="back-button" onclick="window.location.href='index.php'">Kembali</button>
    </div>
</body>
</html>