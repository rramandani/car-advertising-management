<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $new_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);

    $query = "UPDATE users SET password='$new_password' WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: manajemen_user.php?pesan=password_updated");
        exit;
    } else {
        echo "❌ Gagal mengubah password: " . mysqli_error($conn);
    }
}
?>