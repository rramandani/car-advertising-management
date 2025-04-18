<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $hapus = mysqli_query($conn, "DELETE FROM iklan WHERE id = $id");

    if ($hapus) {
        header("Location: data_iklan.php");
        exit;
    } else {
        echo "Gagal menghapus iklan.";
    }
} else {
    header("Location: data_iklan.php");
    exit;
}
?>