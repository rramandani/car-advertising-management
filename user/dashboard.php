<?php
session_start();
include '../config/database.php';
include '../includes/navbar.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .carousel-inner {
            height: 200px;
        }

        .carousel-inner img {
            height: 100%;
            object-fit: cover;
        }

        .modal-img {
            max-height: 400px;
            object-fit: cover;
        }

        .btn-troli {
            background-color: #0d6efd;
            color: white;
        }

        .btn-troli:hover {
            background-color: #0b5ed7;
        }

        .info-box {
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4 text-center">Semua Iklan Mobil</h2>
        <div class="row g-4">

            <?php
            $iklan_result = mysqli_query($conn, "
                SELECT iklan.*, users.username 
                FROM iklan 
                JOIN users ON iklan.user_id = users.id 
                ORDER BY iklan.created_at DESC
            ");

            while ($iklan = mysqli_fetch_assoc($iklan_result)) {
                $id_iklan = $iklan['id'];
                $gambar_result = mysqli_query($conn, "SELECT nama_file FROM gambar_iklan WHERE iklan_id = $id_iklan");
                ?>
                <div class="col-md-4">
                    <div class="card shadow-sm animate__animated animate__fadeInUp" data-bs-toggle="modal"
                        data-bs-target="#modalIklan<?= $id_iklan ?>">
                        <div id="carousel<?= $id_iklan ?>" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $active = true;
                                while ($gambar = mysqli_fetch_assoc($gambar_result)) {
                                    ?>
                                    <div class="carousel-item <?= $active ? 'active' : '' ?>">
                                        <img src="/iklanmobil/uploads/<?= $gambar['nama_file'] ?>" class="d-block w-100"
                                            alt="Gambar Mobil">
                                    </div>
                                    <?php $active = false;
                                } ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $id_iklan ?>"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $id_iklan ?>"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($iklan['judul']) ?></h5>
                            <p class="card-text text-primary fw-bold">Rp<?= number_format($iklan['harga'], 0, ',', '.') ?>
                            </p>
                            <div class="info-box mb-2">
                                Kategori: <?= htmlspecialchars($iklan['kategori']) ?> <br>
                                Oleh: <a href="/iklanmobil/user/profil_pengguna.php?id=<?= $iklan['user_id'] ?>"
                                    class="text-decoration-none">
                                    <?= htmlspecialchars($iklan['username']) ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Detail -->
                <div class="modal fade" id="modalIklan<?= $id_iklan ?>" tabindex="-1"
                    aria-labelledby="modalLabel<?= $id_iklan ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content animate__animated animate__zoomIn">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel<?= $id_iklan ?>">
                                    <?= htmlspecialchars($iklan['judul']) ?>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                $gambar_modal = mysqli_query($conn, "SELECT nama_file FROM gambar_iklan WHERE iklan_id = $id_iklan");
                                ?>
                                <div class="row">
                                    <?php while ($g = mysqli_fetch_assoc($gambar_modal)): ?>
                                        <div class="col-md-4 mb-3">
                                            <img src="/iklanmobil/uploads/<?= $g['nama_file'] ?>"
                                                class="img-fluid modal-img rounded">
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                                <p><strong>Harga:</strong> Rp<?= number_format($iklan['harga'], 0, ',', '.') ?></p>
                                <p><strong>Kategori:</strong> <?= htmlspecialchars($iklan['kategori']) ?></p>
                                <p><strong>Deskripsi:</strong><br><?= nl2br(htmlspecialchars($iklan['deskripsi'])) ?></p>
                                <p class="text-muted">
                                    <strong>Penjual:</strong>
                                    <a href="/iklanmobil/user/profil_pengguna.php?id=<?= $iklan['user_id'] ?>"
                                        class="text-decoration-none">
                                        <?= htmlspecialchars($iklan['username']) ?>
                                    </a>
                                </p>

                                <form action="/iklanmobil/user/aksi_troli.php" method="POST" class="mt-4">
                                    <input type="hidden" name="iklan_id" value="<?= $iklan['id'] ?>">
                                    <button type="submit" class="btn btn-troli w-100">
                                        <i class="bi bi-cart-plus"></i> Tambah ke Troli
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-collapsed');
        }
    </script>
</body>

</html>