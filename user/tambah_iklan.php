<?php
session_start();
if ($_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/database.php';
include '../includes/navbar.php';

$username = $_SESSION['username'];
$user_query = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
$user_data = mysqli_fetch_assoc($user_query);
$user_id = $user_data['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = (int) $_POST['harga'];
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $created_at = date("Y-m-d H:i:s");

    $query = "INSERT INTO iklan (user_id, judul, deskripsi, harga, kategori, created_at) 
              VALUES ('$user_id', '$judul', '$deskripsi', '$harga', '$kategori', '$created_at')";

    if (mysqli_query($conn, $query)) {
        $iklan_id = mysqli_insert_id($conn); // Ambil ID iklan terbaru

        // Proses upload gambar
        if (!empty($_FILES['gambar']['name'][0])) {
            $total_files = count($_FILES['gambar']['name']);
            for ($i = 0; $i < $total_files; $i++) {
                $file_name = time() . '_' . $_FILES['gambar']['name'][$i];
                $file_tmp = $_FILES['gambar']['tmp_name'][$i];
                $target_path = "../uploads/" . $file_name;

                if (move_uploaded_file($file_tmp, $target_path)) {
                    mysqli_query($conn, "INSERT INTO gambar_iklan (iklan_id, nama_file) VALUES ('$iklan_id', '$file_name')");
                }
            }
        }

        header("Location: iklan_saya.php");
        exit;
    } else {
        $error = "Gagal menambahkan iklan. Coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Iklan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-4">
        <h3 class="mb-4">Tambah Iklan</h3>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Judul Iklan</label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Kategori</label>
                <select name="kategori" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="SUV">SUV</option>
                    <option value="Sedan">Sedan</option>
                    <option value="MPV">MPV</option>
                    <option value="Hatchback">Hatchback</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Upload Gambar (boleh lebih dari satu)</label>
                <input type="file" name="gambar[]" class="form-control" multiple accept="image/*">
            </div>
            <button type="submit" class="btn btn-danger">Simpan</button>
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