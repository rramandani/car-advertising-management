foreach ($_FILES['gambar']['tmp_name'] as $i => $tmpName) {
$nama_file = time() . '_' . $_FILES['gambar']['name'][$i];
move_uploaded_file($tmpName, '../uploads/' . $nama_file);

mysqli_query($conn, "INSERT INTO gambar_iklan (iklan_id, nama_file) VALUES ($iklan_id, '$nama_file')");
}