<?php 
include ('config.php');

$no_dorm = $_GET['id'];
$result = mysqli_query($mysqli, "DELETE FROM senarai_aduan WHERE no_dorm='$no_dorm'");

echo "<script>alert('Maklumat berjaya dihapuskan.');". "window.location='homepage.php'</script>";
?>