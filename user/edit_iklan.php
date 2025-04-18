<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/database.php';
include '../includes/navbar.php';

$username = $_SESSION['username'];
$user_query = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
$user_data = mysqli_fetch_assoc($user_query);
$user_id = $user_data['id'];

if (!isset($_GET['id'])) {
    echo "ID Iklan tidak valid.";
    exit;
}

$id_iklan = intval($_GET['id']);

// Cek apakah iklan milik user yang login
$cek = mysqli_query($conn, "SELECT * FROM iklan WHERE id = $id_iklan AND user_id = $user_id");
$iklan = mysqli_fetch_assoc($cek);
if (!$iklan) {
    echo "Iklan tidak ditemukan atau bukan milik Anda.";
    exit;
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $harga = intval($_POST['harga']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $update = mysqli_query($conn, "UPDATE iklan SET judul='$judul', harga=$harga, kategori='$kategori', deskripsi='$deskripsi' WHERE id = $id_iklan");

    if ($update) {
        echo "<script>alert('Iklan berhasil diperbarui!'); window.location='iklan_saya.php';</script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Gagal memperbarui iklan.</div>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Iklan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h3>Edit Iklan</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($iklan['judul']) ?>"
                    required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" value="<?= $iklan['harga'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <input type="text" name="kategori" class="form-control"
                    value="<?= htmlspecialchars($iklan['kategori']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="5"
                    required><?= htmlspecialchars($iklan['deskripsi']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="iklan_saya.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-collapsed');
        }
    </script>
</body>

</html>