<?php
include('config.php');

// Tangani pembaruan status
if (isset($_POST['update_status'])) {
    $no_dorm = $_POST['no_dorm'];
    $new_status = $_POST['status'];

    $update_query = "UPDATE senarai_aduan SET status='$new_status' WHERE no_dorm='$no_dorm'";
    mysqli_query($mysqli, $update_query);
    header('Location: ' . $_SERVER['PHP_SELF']); // Refresh halaman selepas pembaruan
    exit;
}

// Ambil data statistik
$total_users_query = "SELECT COUNT(*) AS total FROM user";
$total_users_result = mysqli_query($mysqli, $total_users_query);
$total_users = mysqli_fetch_assoc($total_users_result)['total'];

$total_complaints_query = "SELECT COUNT(*) AS total FROM senarai_aduan";
$total_complaints_result = mysqli_query($mysqli, $total_complaints_query);
$total_complaints = mysqli_fetch_assoc($total_complaints_result)['total'];

$pending_complaints_query = "SELECT COUNT(*) AS total FROM senarai_aduan WHERE status='Belum Selesai'";
$pending_complaints_result = mysqli_query($mysqli, $pending_complaints_query);
$pending_complaints = mysqli_fetch_assoc($pending_complaints_result)['total'];

$resolved_complaints_query = "SELECT COUNT(*) AS total FROM senarai_aduan WHERE status='Selesai'";
$resolved_complaints_result = mysqli_query($mysqli, $resolved_complaints_query);
$resolved_complaints = mysqli_fetch_assoc($resolved_complaints_result)['total'];

// Ambil semua data pengguna
$users_query = "SELECT * FROM user";
$users_result = mysqli_query($mysqli, $users_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-image: url('view asrama.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    color: #333;
    animation: fadeInBody 1s ease-in;
}

@keyframes fadeInBody {
    from { opacity: 0; }
    to { opacity: 1; }
}

header {
    background-color: rgba(0,0,0,0.5);
    color: white;
    text-align: center;
    padding: 20px 0;
    animation: slideDown 0.8s ease-out;
}

@keyframes slideDown {
    from { transform: translateY(-30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

nav {
    background-color: rgba(255, 255, 255, 0.8);
    padding: 10px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    animation: fadeInNav 1s ease-in;
}

@keyframes fadeInNav {
    from { opacity: 0; }
    to { opacity: 1; }
}

nav a {
    color: black;
    text-decoration: none;
    margin: 0 15px;
    font-size: 16px;
    padding: 10px 15px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

nav a:hover {
    background-color: #ddd;
}

.container {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
    background-color: rgba(255,255,255,0.95);
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    animation: fadeInContainer 1.2s ease-in;
}

@keyframes fadeInContainer {
    from { transform: scale(0.97); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.stats {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background-color: #ffffff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    width: 22%;
    flex-grow: 1;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-card h3 {
    font-size: 16px;
    color: #666;
    margin-bottom: 10px;
}

.stat-card p {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

.card {
    background: white;
    padding: 20px;
    margin-top: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    animation: fadeInCard 0.7s ease;
}

@keyframes fadeInCard {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-size: 14px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 10px 12px;
    text-align: left;
    vertical-align: middle;
}

th {
    background-color: #f7f7f7;
    font-weight: bold;
}

td img {
    border-radius: 5px;
    width: 100px;
    height: auto;
    transition: transform 0.3s ease;
}

td img:hover {
    transform: scale(1.05);
}

select {
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
    width: 100%;
}

button {
    padding: 8px 15px;
    border: none;
    background-color: #4CAF50;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #45a049;
}

.form-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.form-container input[type="submit"] {
    width: auto;
}

.form-container select {
    width: 100%;
}

a.confirm-link {
    display: inline-block;
    padding: 8px 12px;
    background-color: #e74c3c;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s, transform 0.3s;
    font-size: 14px;
}

a.confirm-link:hover {
    background-color: #c0392b;
    transform: scale(1.05);
}

.no-records {
    text-align: center;
    font-size: 18px;
    color: #777;
    padding: 20px 0;
}

/* Responsive */
@media (max-width: 768px) {
    .stats {
        flex-direction: column;
        gap: 15px;
    }

    .stat-card {
        width: 100%;
    }

    table, th, td {
        font-size: 12px;
    }

    td img {
        width: 80px;
    }

    nav a {
        display: block;
        margin: 10px auto;
    }
}

    </style>
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <nav>
        <a href="homepage.php">Homepage Warden</a>
        <a href="index.php">Log Keluar</a>
    </nav>

    <div class="container">
        <!-- Statistik -->
        <div class="stats">
            <div class="stat-card">
                <h3>Jumlah Pengguna</h3>
                <p><?php echo $total_users; ?></p>
            </div>
            <div class="stat-card">
                <h3>Jumlah Aduan</h3>
                <p><?php echo $total_complaints; ?></p>
            </div>
            <div class="stat-card">
                <h3>Aduan Belum Selesai</h3>
                <p><?php echo $pending_complaints; ?></p>
            </div>
            <div class="stat-card">
                <h3>Aduan Selesai</h3>
                <p><?php echo $resolved_complaints; ?></p>
            </div>
        </div>

        <!-- Senarai Aduan -->
        <div class="card">
            <h2>Senarai Aduan</h2>
            <table>
                <tr>
                    <th>No. Dorm</th>
                    <th>Nama Pelajar</th>
                    <th>No. Tel Pelajar</th>
                    <th>Email Pelajar</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th>Gambar</th>
                    <th>Status</th>
                    <th>Tindakan</th>
                </tr>
                <?php
                $query = "SELECT * FROM senarai_aduan";
                $result = mysqli_query($mysqli, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['no_dorm']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama_pelajar']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['notel_pelajar']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email_pelajar']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['kategori']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['keterangan']) . "</td>";
                        echo "<td><img src='uploads/" . htmlspecialchars($row['gambar']) . "' alt='Gambar Aduan'></td>";
                        echo "<td>
                                <form method='POST' class='form-container'>
                                    <input type='hidden' name='no_dorm' value='" . $row['no_dorm'] . "'>
                                    <select name='status' onchange='this.form.submit()'>
                                        <option value='Belum Selesai' " . ($row['status'] == 'Belum Selesai' ? 'selected' : '') . ">Belum Selesai</option>
                                        <option value='Selesai' " . ($row['status'] == 'Selesai' ? 'selected' : '') . ">Selesai</option>
                                    </select>
                                    <input type='hidden' name='update_status' value='true'>
                                </form>
                            </td>";
                        echo "<td>
                        <a class='confirm-link' href=\"delete1.php?id=$row[no_dorm]\" onClick=\"return confirm('Adakah anda pasti?')\">
                            <i class='fas fa-trash'></i> PADAM </a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='no-records'>Tiada aduan</td></tr>";
                }
                ?>
            </table>
        </div>

        <!-- Senarai Pengguna -->
        <div class="card">
            <h2>Senarai Pengguna</h2>
            <table>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Kata Laluan Pengguna</th>
                    <th>Kategori (User/Admin/Warden)</th>
                </tr>
                <?php
                if (mysqli_num_rows($users_result) > 0) {
                    while ($user = mysqli_fetch_assoc($users_result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['password']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['usertype']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='no-records'>Tiada pengguna</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>