<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../config/database.php';
include '../includes/navbar.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data troli user
$query = "SELECT troli.*, iklan.judul, iklan.harga, gambar_iklan.nama_file 
          FROM troli 
          JOIN iklan ON troli.iklan_id = iklan.id 
          LEFT JOIN gambar_iklan ON iklan.id = gambar_iklan.iklan_id
          WHERE troli.user_id = $user_id
          GROUP BY troli.iklan_id";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Troli Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4 text-center">Troli Saya</h2>

        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <img src="/iklanmobil/uploads/<?= $row['nama_file'] ?>" class="card-img-top" alt="Gambar">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['judul'] ?></h5>
                            <p class="card-text text-muted">Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
                            <form action="hapus_troli.php" method="POST">
                                <input type="hidden" name="troli_id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Hapus dari Troli</button>
                            </form>
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