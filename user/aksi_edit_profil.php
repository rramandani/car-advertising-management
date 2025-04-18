<?php
session_start();
include '../config/database.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: /iklanmobil/auth/login.php");
    exit;
}

$deskripsi = $_POST['deskripsi'] ?? '';
$foto_nama = null;

// Handle upload foto
if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
    $foto_tmp = $_FILES['foto_profil']['tmp_name'];
    $foto_nama_asli = $_FILES['foto_profil']['name'];
    $ext = strtolower(pathinfo($foto_nama_asli, PATHINFO_EXTENSION));

    // Validasi ekstensi
    $ekstensi_valid = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($ext, $ekstensi_valid)) {
        $foto_nama = uniqid('profil_') . '.' . $ext;
        $lokasi_simpan = "../uploads/$foto_nama";

        // Cek apakah fungsi GD aktif
        if (function_exists('imagecreatetruecolor')) {
            list($lebar_asli, $tinggi_asli) = getimagesize($foto_tmp);
            $lebar_baru = 300;
            $tinggi_baru = 300;
            $thumb = imagecreatetruecolor($lebar_baru, $tinggi_baru);

            switch ($ext) {
                case 'jpg':
                case 'jpeg':
                    $src = imagecreatefromjpeg($foto_tmp);
                    break;
                case 'png':
                    $src = imagecreatefrompng($foto_tmp);
                    break;
                case 'gif':
                    $src = imagecreatefromgif($foto_tmp);
                    break;
                default:
                    $src = null;
            }

            if ($src) {
                imagecopyresampled($thumb, $src, 0, 0, 0, 0, $lebar_baru, $tinggi_baru, $lebar_asli, $tinggi_asli);
                imagejpeg($thumb, $lokasi_simpan, 90);
                imagedestroy($thumb);
                imagedestroy($src);
            }
        } else {
            // Jika GD tidak aktif, langsung simpan tanpa resize
            move_uploaded_file($foto_tmp, $lokasi_simpan);
        }
    }
}

// Update database
if ($foto_nama) {
    $stmt = $conn->prepare("UPDATE users SET deskripsi = ?, foto_profil = ? WHERE id = ?");
    $stmt->bind_param("ssi", $deskripsi, $foto_nama, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE users SET deskripsi = ? WHERE id = ?");
    $stmt->bind_param("si", $deskripsi, $user_id);
}

if ($stmt->execute()) {
    header("Location: /iklanmobil/user/profil_pengguna.php?id=" . $user_id);
    exit;
} else {
    echo "Gagal menyimpan perubahan.";
}
?>