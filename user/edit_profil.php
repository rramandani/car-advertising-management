<?php
session_start();
include '../config/database.php';

$user_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id"));
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function previewFoto(input) {
            const imgPreview = document.getElementById('imgPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imgPreview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <style>
        #imgPreview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ddd;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <a href="/iklanmobil/user/profil_pengguna.php?id=<?= $user_id ?>" class="btn btn-secondary mb-4">
            <i class="bi bi-arrow-left"></i> Kembali ke Profil
        </a>

        <div class="card p-4">
            <h3 class="mb-4">Edit Profil</h3>
            <form method="POST" action="aksi_edit_profil.php" enctype="multipart/form-data">
                <div class="mb-3 text-center">
                    <img src="/iklanmobil/uploads/<?= $user['foto_profil'] ?: 'default.png' ?>" id="imgPreview"
                        alt="Foto Profil">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ganti Foto Profil</label>
                    <input type="file" name="foto_profil" class="form-control" onchange="previewFoto(this)">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi Profil</label>
                    <textarea name="deskripsi" class="form-control"
                        rows="4"><?= htmlspecialchars($user['deskripsi']) ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-collapsed');
        }
    </script>
</body>

</html>