<?php
session_start();
include '../config/database.php';

$id = $_POST['id'];
$role = $_POST['role'];

// Eksekusi query untuk update role
$query = mysqli_query($conn, "UPDATE users SET role = '$role' WHERE id = '$id'");

if ($query) {
    // Jika berhasil, kirim pesan sukses
    $_SESSION['pesan'] = 'Role berhasil diperbarui!';
} else {
    // Jika gagal, kirim pesan error
    $_SESSION['pesan'] = 'Gagal memperbarui role!';
}

header("Location: manajemen_user.php");
exit;
?>