<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}
?>

<h2>Tambah Pengguna Baru</h2>
<form method="post" action="proses_tambah_pengguna.php">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <select name="role" required>
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br><br>
    <button type="submit">Tambah</button>
</form>