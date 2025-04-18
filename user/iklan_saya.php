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

$query = "SELECT * FROM iklan WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Iklan Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Iklan Saya</h3>
            <a href="tambah_iklan.php" class="btn btn-success">+ Tambah Iklan</a>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['judul'] ?></td>
                        <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><?= $row['kategori'] ?></td>
                        <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
                        <td>
                            <a href="edit_iklan.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus_iklan.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus iklan ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-collapsed');
        }
    </script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-collapsed');
        }
    </script>
</body>

</html>