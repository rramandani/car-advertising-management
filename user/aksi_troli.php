<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$iklan_id = $_POST['iklan_id'] ?? null;

if ($iklan_id) {
    // Cek apakah sudah ada di troli
    $cek = mysqli_query($conn, "SELECT * FROM troli WHERE user_id = '$user_id' AND iklan_id = '$iklan_id'");

    if (mysqli_num_rows($cek) > 0) {
        // Sudah ada
        $_SESSION['notif'] = "Iklan sudah ada di troli kamu.";
    } else {
        // Tambahkan ke troli
        $query = "INSERT INTO troli (user_id, iklan_id) VALUES ('$user_id', '$iklan_id')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['notif'] = "Iklan berhasil ditambahkan ke troli.";
        } else {
            $_SESSION['notif'] = "Gagal menambahkan ke troli.";
        }
    }

    header("Location: dashboard.php");
    exit;
} else {
    echo "Data tidak lengkap.";
}
?>