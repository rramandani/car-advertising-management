<?php
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];

    $query = "DELETE FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "✅ Pengguna berhasil dihapus.";
    } else {
        echo "❌ Gagal menghapus pengguna: " . mysqli_error($conn);
    }
}
?>