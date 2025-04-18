<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}


include '../config/database.php';
include '../includes/navbar.php';

// Ambil data statistik
$jumlah_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role='user'"))['total'];
$jumlah_iklan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM iklan"))['total'];
$iklan_terbaru = mysqli_query($conn, "SELECT * FROM iklan ORDER BY created_at DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .dashboard-box {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
        }

        .dashboard-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #0d6efd;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="mb-4 text-center">
            <h2>Dashboard Admin</h2>
            <p class="text-muted">Statistik singkat dan iklan terbaru</p>
        </div>

        <div class="row g-4 mb-4 text-center">
            <div class="col-md-6">
                <div class="p-4 bg-white dashboard-box h-100">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="icon-circle me-3 bg-danger"><i class="bi bi-people-fill"></i></div>
                        <div>
                            <h5 class="mb-1">Jumlah Pengguna</h5>
                            <p class="display-6 text-danger"><?= $jumlah_user ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 bg-white dashboard-box h-100">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="icon-circle me-3 bg-dark"><i class="bi bi-car-front-fill"></i></div>
                        <div>
                            <h5 class="mb-1">Jumlah Iklan</h5>
                            <p class="display-6 text-dark"><?= $jumlah_iklan ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mb-3">Iklan Terbaru</h4>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Harga</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($row = mysqli_fetch_assoc($iklan_terbaru)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['judul']) ?></td>
                            <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($row['kategori']) ?></td>
                            <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="/iklanmobil/auth/logout.php" class="btn btn-outline-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
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