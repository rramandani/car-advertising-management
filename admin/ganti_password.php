<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil ID user dari query string
$id = $_GET['id'];
?>

<h2>Ganti Password Pengguna</h2>
<form method="post" action="proses_ganti_password.php">
    <input type="hidden" name="id" value="<?= $id ?>">
    <input type="password" name="new_password" placeholder="Password Baru" required><br><br>
    <button type="submit">Ganti Password</button>
</form>