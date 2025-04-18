<?php
session_start();
include '../config/database.php';

$user_id = $_GET['id'] ?? null;

if (!$user_id) {
    echo "User tidak ditemukan.";
    exit;
}

$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user_data = mysqli_fetch_assoc($user_query);

if (!$user_data) {
    echo "Data user tidak tersedia.";
    exit;
}

$iklan_query = mysqli_query($conn, "SELECT * FROM iklan WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Profil Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">

        <!-- Tombol Kembali ke Beranda -->
        <a href="/iklanmobil/user/dashboard.php" class="btn btn-secondary mb-4">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>

        <div class="card p-4 mb-4">
            <div class="row g-4 align-items-center">
                <div class="col-md-3 text-center">
                    <img src="/iklanmobil/uploads/<?= $user_data['foto_profil'] ?: 'default.png' ?>"
                        class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <div class="col-md-9">
                    <h3><?= $user_data['username'] ?></h3>
                    <p><?= nl2br($user_data['deskripsi']) ?: '<em>Belum ada deskripsi.</em>' ?></p>
                </div>
            </div>
        </div>

        <h4>Iklan oleh <?= $user_data['username'] ?></h4>
        <div class="row">
            <?php while ($iklan = mysqli_fetch_assoc($iklan_query)): ?>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <?php
                        $id_iklan = $iklan['id'];
                        $gambar = mysqli_query($conn, "SELECT nama_file FROM gambar_iklan WHERE iklan_id = $id_iklan LIMIT 1");
                        $g = mysqli_fetch_assoc($gambar);
                        ?>
                        <img src="/iklanmobil/uploads/<?= $g['nama_file'] ?? 'default.jpg' ?>" class="card-img-top"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $iklan['judul'] ?></h5>
                            <p class="card-text text-muted">Rp<?= number_format($iklan['harga'], 0, ',', '.') ?></p>
                            <a href="/iklanmobil/user/dashboard.php#modalIklan<?= $id_iklan ?>"
                                class="btn btn-sm btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-collapsed');
        }
    </script>
</body>

</html>