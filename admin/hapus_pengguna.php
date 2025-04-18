<h2>Hapus Pengguna</h2>
<form method="post" action="proses_hapus_pengguna.php">
    <input type="text" name="username" placeholder="Username yang akan dihapus" required><br><br>
    <button type="submit" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</button>
</form>