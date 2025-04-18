<?php
session_start();
include '../config/database.php';
include '../includes/navbar.php';

// Cek login & role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Hapus user
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM users WHERE id = '$id'");
    header("Location: manajemen_user.php");
    exit;
}

// Ubah role user
if (isset($_GET['ubah_role'])) {
    $id = $_GET['ubah_role'];
    $query = mysqli_query($conn, "SELECT role FROM users WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query);
    $new_role = ($data['role'] === 'admin') ? 'user' : 'admin';
    mysqli_query($conn, "UPDATE users SET role = '$new_role' WHERE id = '$id'");
    header("Location: manajemen_user.php");
    exit;
}

// Pencarian
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$query = "SELECT * FROM users WHERE username LIKE '%$cari%' OR email LIKE '%$cari%' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manajemen User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
        }

        .container {
            margin-top: 50px;
        }

        .btn-sm {
            padding: 4px 10px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <?php '../includes/navbar.php'; ?>

    <div class="container">
        <h3 class="mb-4">Manajemen User</h3>

        <!-- Notifikasi sukses -->
        <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'sukses_tambah'): ?>
            <div class="alert alert-success">✅ Pengguna baru berhasil ditambahkan.</div>
        <?php endif; ?>
        <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'password_updated'): ?>
            <div class="alert alert-info">🔒 Password berhasil diubah.</div>
        <?php endif; ?>

        <!-- Tombol tambah -->
        <a href="tambah_pengguna.php" class="btn btn-success mb-3">Tambah Pengguna</a>

        <!-- Form pencarian -->
        <form class="row g-3 mb-3" method="GET">
            <div class="col-auto">
                <input type="text" name="cari" class="form-control" placeholder="Cari username/email..."
                    value="<?= htmlspecialchars($cari) ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="manajemen_user.php" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <!-- Tabel user -->
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="250">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($user = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= $user['role'] ?></td>
                            <td>
                                <?php if ($_SESSION['user_id'] != $user['id']): ?>
                                    <a href="?ubah_role=<?= $user['id'] ?>" class="btn btn-warning btn-sm"
                                        onclick="return confirm('Ubah role user ini?')">Ubah Role</a>
                                    <a href="?hapus=<?= $user['id'] ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus user ini?')">Hapus</a>
                                    <a href="ganti_password.php?id=<?= $user['id'] ?>" class="btn btn-info btn-sm">Password</a>
                                <?php else: ?>
                                    <span class="text-muted">Tidak bisa ubah diri sendiri</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data user.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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