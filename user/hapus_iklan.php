<?php
session_start();
if ($_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/database.php';

$id = $_GET['id'];
$username = $_SESSION['username'];

// Cek ID user login
$user_query = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
$user_data = mysqli_fetch_assoc($user_query);
$user_id = $user_data['id'];

// Cek apakah iklan milik user
$cek_query = mysqli_query($conn, "SELECT * FROM iklan WHERE id=$id AND user_id=$user_id");
if (mysqli_num_rows($cek_query) == 0) {
    echo "<script>alert('Iklan tidak ditemukan atau Anda tidak punya akses.'); window.location='iklan_saya.php';</script>";
    exit;
}

// Hapus iklan
mysqli_query($conn, "DELETE FROM iklan WHERE id=$id AND user_id=$user_id");

// Redirect ke halaman iklan
header("Location: iklan_saya.php");
exit;
?>