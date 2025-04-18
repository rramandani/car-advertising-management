<?php
include '../config/database.php';
include '../includes/navbar.php';

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$query = "SELECT * FROM iklan WHERE judul LIKE '%$keyword%' OR kategori LIKE '%$keyword%' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Cari Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h3 class="mb-4 text-center">Pencarian Mobil</h3>

        <form method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control"
                    placeholder="Cari berdasarkan judul atau kategori" value="<?= htmlspecialchars($keyword) ?>">
                <button class="btn btn-dark" type="submit">Cari</button>
            </div>
        </form>

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
                <?php
                $no = 1;
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