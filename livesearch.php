<?php
include("config.php");

if (isset($_POST['input'])) {
    $input = $_POST['input'];
    $query = "SELECT * FROM senarai_aduan WHERE nama_pelajar LIKE '{$input}%' OR no_dorm LIKE '{$input}%'";
    $result = mysqli_query($mysqli, $query);
} else {
    $input = '';
    $result = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carian Aduan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('view asrama.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            max-width: 90%;
            width: 800px;
            margin: 50px auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1s ease-out; /* Animation for container fade-in */
        }

        #logo {
            max-width: 100px;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed;
            animation: slideUp 1s ease-out; /* Animation for table sliding up */
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            word-wrap: break-word;
            white-space: normal;
            overflow-wrap: break-word;
            max-width: 200px;
            opacity: 0;
            animation: fadeInRows 1s ease-out forwards; /* Animation for row fade-in */
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        h6 {
            color: red;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
        }

        .placeholder {
            text-align: center;
            font-size: 18px;
            color: #777;
            margin-top: 20px;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            0% {
                transform: translateY(20px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInRows {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center">
            <img id="logo" src="logokvsepang.jpg" alt="Logo">
            <h1>Hasil Carian Aduan</h1>
        </div>

        <?php
        if (!empty($input)) {
            if (mysqli_num_rows($result) > 0) { ?>
                <table>
                    <thead>
                        <tr>
                            <th>NO DORM</th>
                            <th>NAMA PELAJAR</th>
                            <th>NO. TELEFON PELAJAR</th>
                            <th>EMAIL PELAJAR</th>
                            <th>KATEGORI</th>
                            <th>KETERANGAN</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row["no_dorm"]; ?></td>
                                <td><?php echo $row["nama_pelajar"]; ?></td>
                                <td><?php echo $row["notel_pelajar"]; ?></td>
                                <td><?php echo $row["email_pelajar"]; ?></td>
                                <td><?php echo $row["kategori"]; ?></td>
                                <td><?php echo $row["keterangan"]; ?></td>
                                <td><?php echo $row["status"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <h6>Harap Maaf! Aduan anda tiada dalam data!</h6>
            <?php }
        } else {
            echo "<div class='placeholder'>Sila masukkan kata kunci carian untuk melihat hasil aduan.</div>";
        }
        ?>
    </div>
</body>
</html>
