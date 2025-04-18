<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Profil Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h3>Profil Saya</h3>
        <div class="card p-3 shadow-sm">
            <?php if ($user['foto_profil']): ?>
                <img src="../uploads/<?= $user['foto_profil'] ?>" width="120" class="rounded mb-3">
            <?php endif; ?>
            <p><strong>Username:</strong> <?= $user['username'] ?></p>
            <p><strong>Deskripsi:</strong><br><?= nl2br($user['deskripsi']) ?></p>
            <a href="edit_profil.php" class="btn btn-outline-primary">Edit Profil</a>
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