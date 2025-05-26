<?php
include 'config.php';

// Tangani pembaruan status
if (isset($_POST['update_status'])) {
    $no_dorm = $_POST['no_dorm'];
    $new_status = $_POST['status'];

    $update_query = "UPDATE senarai_aduan SET status='$new_status' WHERE no_dorm='$no_dorm'";
    mysqli_query($mysqli, $update_query);
    header('Location: ' . $_SERVER['PHP_SELF']); // Refresh halaman setelah pembaruan
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Aduan Pelajar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

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
        }

        h2 {
            text-align: center;
            padding: 20px;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .table-container {
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        table {
            width: 100%;
            max-width: 1200px;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: middle;
        }

        th {
            background-color: #1e88e5;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f2faff;
        }

        tr:hover {
            background-color: #e0f7fa;
        }

        .button, .logout-button, .popup button {
            background-color: #1e88e5;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .button:hover, .logout-button:hover, .popup button:hover {
            background-color: #1565c0;
            transform: scale(1.1);
        }

        .confirm-link {
            color: #d9534f;
            font-weight: bold;
        }

        .confirm-link:hover i {
            transform: scale(1.2);
            color: #f44336;
            transition: transform 0.3s, color 0.3s;
        }

        .logout-button {
            background-color: #d9534f;
            margin-top: 20px;
        }

        .logout-button:hover {
            background-color: #c9302c;
        }

        select {
            padding: 6px 10px;
            border-radius: 5px;
            border: 1px solid #bbb;
            font-size: 14px;
            background-color: #fff;
        }

        @keyframes popupAnimation {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            z-index: 1000;
            text-align: center;
            padding: 20px;
        }

        .popup img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
        }


        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .footer {
            text-align: center;
            margin: 30px 0;
        }

        @media (max-width: 768px) {
            table, th, td {
                font-size: 12px;
                padding: 10px;
            }

            .button, .logout-button {
                width: 100%;
            }

            .popup {
                max-width: 95%;
            }
        }

        @media print {
            body * {
                visibility: hidden;
            }
            table, table * {
                visibility: visible;
            }
            table {
                position: absolute;
                top: 0;
                left: 0;
            }
        }
    </style>
</head>
<body>
    <h2>SENARAI ADUAN ASRAMA</h2>

    <!-- Penapis Kategori -->
    <form method="GET" style="text-align: center; margin-bottom: 20px;">
        <label for="filter">Menapis mengikut kategori:</label>
        <select name="filter" id="filter" onchange="this.form.submit()">
            <option value="">-- Semua Kategori --</option>
            <option value="Elektrikal" <?= (isset($_GET['filter']) && $_GET['filter'] == 'Elektrikal') ? 'selected' : '' ?>>Elektrikal</option>
            <option value="Fasiliti" <?= (isset($_GET['filter']) && $_GET['filter'] == 'Fasiliti') ? 'selected' : '' ?>>Fasiliti</option>
            <option value="Perabot" <?= (isset($_GET['filter']) && $_GET['filter'] == 'Perabot') ? 'selected' : '' ?>>Perabot</option>
        </select>
    </form>

    <div style="text-align:center; margin-top:-10px;">
        <button onclick="window.print()" class="button" style="margin-bottom: 10px;">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
    </div>

    <div class="table-container">
        <table>
            <tr>
                <th>NO DORM</th>
                <th>NAMA PELAJAR</th>
                <th>NO. TELEFON PELAJAR</th>
                <th>EMAIL PELAJAR</th>
                <th>KATEGORI</th>
                <th>KETERANGAN</th>
                <th>GAMBAR KEROSAKAN</th>
                <th>STATUS</th>
                <th>TINDAKAN</th>
            </tr>
            
            <?php
            $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
            if ($filter != '') {
                $query = "SELECT * FROM senarai_aduan WHERE kategori='$filter'";
            } else {
                $query = "SELECT * FROM senarai_aduan";
            }

            $result = mysqli_query($mysqli, $query);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["no_dorm"] . "</td>";
                    echo "<td>" . $row["nama_pelajar"] . "</td>";
                    echo "<td>" . $row["notel_pelajar"] . "</td>";
                    echo "<td>" . $row["email_pelajar"] . "</td>";
                    echo "<td>" . $row["kategori"] . "</td>";
                    echo "<td>" . $row["keterangan"] . "</td>";
                    echo "<td><a href='#' onclick=\"showPopup('uploads/" . $row["gambar"] . "')\">Klik untuk lihat</a></td>";
                    
                    // Form untuk pembaruan status
                    echo "<td>
                        <form method='POST' action=''>
                            <input type='hidden' name='no_dorm' value='" . $row['no_dorm'] . "'>
                            <select name='status' onchange='this.form.submit()'>
                                <option value='Belum Selesai' " . ($row['status'] == 'Belum Selesai' ? 'selected' : '') . ">Belum Selesai</option>
                                <option value='Selesai' " . ($row['status'] == 'Selesai' ? 'selected' : '') . ">Selesai</option>
                            </select>
                            <input type='hidden' name='update_status' value='true'>
                        </form>
                    </td>";

                    // Tindakan Padam
                   echo "<td>
                        <a class='confirm-link' href=\"delete.php?id=$row[no_dorm]\" onClick=\"return confirm('Adakah anda pasti?')\">
                            <i class='fas fa-trash'></i> PADAM </a>
                      </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Tiada data pelajar.</td></tr>";
            }
            ?>
        </table>
    </div>

    <div class="footer">
        <a href="index.php" class="button logout-button">
            <i class="fas fa-sign-out-alt"></i> Log Keluar
        </a>
    </div>

    <!-- Popup Image -->
    <div id="popup" class="popup">
        <img id="popupImage" src="" alt="Gambar Kerosakan">
        <br><br>
        <button class="button" onclick="closePopup()">Tutup</button>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="overlay" onclick="closePopup()"></div>

    <script>
        function showPopup(imageSrc) {
            const popup = document.getElementById('popup');
            const popupImage = document.getElementById('popupImage');
            const overlay = document.getElementById('overlay');

            popupImage.src = imageSrc;
            popup.style.display = 'block';
            overlay.style.display = 'block';
        }

        function closePopup() {
            const popup = document.getElementById('popup');
            const overlay = document.getElementById('overlay');

            popup.style.display = 'none';
            overlay.style.display = 'none';
        }
    </script>
</body>
</html>