<?php
session_start();
require 'koneksi.php'; // Pastikan file ini menghubungkan ke database $conn

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_pengurus'];
    $jabatan = $_POST['jabatan_pengurus'];
    $deskripsi = $_POST['deskripsi_pengurus'];

    // Proses upload foto
    $foto_nama = $_FILES['foto_pengurus']['name'];
    $foto_tmp = $_FILES['foto_pengurus']['tmp_name'];
    $folder_upload = "uploads_pengurus/";

    // Buat folder jika belum ada
    if (!is_dir($folder_upload)) {
        mkdir($folder_upload, 0777, true);
    }

    $foto_path = $folder_upload . basename($foto_nama);
    move_uploaded_file($foto_tmp, $foto_path);

    $query = "INSERT INTO pengurus (nama_pengurus, jabatan_pengurus, deskripsi_pengurus, foto_pengurus)
              VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $nama, $jabatan, $deskripsi, $foto_path);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: adminpage.php"); // Langsung pindah ke halaman admin
        exit();
    } else {
        echo "Gagal menambahkan pengurus: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pengurus</title>
</head>
<body>
    <h2>Form Tambah Pengurus</h2>
    <form action="tambah_pengurus.php" method="POST" enctype="multipart/form-data">
        <label for="nama_pengurus">Nama Pengurus:</label><br>
        <input type="text" name="nama_pengurus" required><br><br>

        <label for="jabatan_pengurus">Jabatan:</label><br>
        <input type="text" name="jabatan_pengurus" required><br><br>

        <label for="deskripsi_pengurus">Deskripsi:</label><br>
        <textarea name="deskripsi_pengurus" rows="5" cols="40" placeholder="Masukkan deskripsi..."></textarea><br><br>

        <label for="foto_pengurus">Unggah Foto:</label><br>
        <input type="file" name="foto_pengurus" accept="image/*"><br><br>

        <input type="submit" value="Simpan Pengurus">
    </form>
</body>
</html>
