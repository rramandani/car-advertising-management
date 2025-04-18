<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/database.php';
include '../includes/navbar.php';

if (!isset($_GET['id'])) {
    header("Location: data_iklan.php");
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM iklan WHERE id = $id");
$data = mysqli_fetch_assoc($query);

// Ambil semua user
$user_result = mysqli_query($conn, "SELECT id, username FROM users WHERE role='user'");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $user_id = $_POST['user_id'];

    $update = mysqli_query($conn, "UPDATE iklan SET 
        judul='$judul', 
        harga='$harga', 
        kategori='$kategori', 
        user_id='$user_id' 
        WHERE id=$id");

    if ($update) {
        header("Location: data_iklan.php");
        exit;
    } else {
        $error = "Gagal memperbarui data iklan.";
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
    <div class="container py-4">
        <h3 class="mb-4">Edit Iklan</h3>
        <?php if (isset($error))
            echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" value="<?= $data['judul'] ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" value="<?= $data['harga'] ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Kategori</label>
                <select name="kategori" class="form-control" required>
                    <option value="SUV" <?= $data['kategori'] == 'SUV' ? 'selected' : '' ?>>SUV</option>
                    <option value="Sedan" <?= $data['kategori'] == 'Sedan' ? 'selected' : '' ?>>Sedan</option>
                    <option value="Hatchback" <?= $data['kategori'] == 'Hatchback' ? 'selected' : '' ?>>Hatchback</option>
                    <option value="MPV" <?= $data['kategori'] == 'MPV' ? 'selected' : '' ?>>MPV</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Pengguna</label>
                <select name="user_id" class="form-control" required>
                    <?php while ($user = mysqli_fetch_assoc($user_result)) { ?>
                        <option value="<?= $user['id'] ?>" <?= $user['id'] == $data['user_id'] ? 'selected' : '' ?>>
                            <?= $user['username'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-dark">Update</button>
            <a href="data_iklan.php" class="btn btn-secondary">Batal</a>
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