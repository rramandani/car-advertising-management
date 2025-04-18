<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: manajemen_user.php?pesan=sukses_tambah");
        exit;
    } else {
        echo "❌ Gagal menambahkan user: " . mysqli_error($conn);
    }
}
?>