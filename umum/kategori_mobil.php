<?php
include '../config/database.php';
include '../includes/navbar.php';

$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

$query = "SELECT * FROM iklan";
if (!empty($kategori)) {
    $query .= " WHERE kategori = '$kategori'";
}
$query .= " ORDER BY created_at DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Kategori Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h3 class="mb-4 text-center">Kategori Mobil</h3>

        <div class="mb-4 text-center">
            <a href="?kategori=SUV" class="btn btn-outline-dark me-2">SUV</a>
            <a href="?kategori=MPV" class="btn btn-outline-dark me-2">MPV</a>
            <a href="?kategori=Sedan" class="btn btn-outline-dark me-2">Sedan</a>
            <a href="kategori_mobil.php" class="btn btn-secondary">Tampilkan Semua</a>
        </div>

        <table class="table table-bordered table-striped">
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
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['judul'] ?></td>
                        <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><?= $row['kategori'] ?></td>
                        <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
                    </tr>
                <?php }
                if ($no == 1) {
                    echo "<tr><td colspan='5' class='text-center'>Tidak ada iklan ditemukan</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-collapsed');
        }
    </script>
</body>

</html>