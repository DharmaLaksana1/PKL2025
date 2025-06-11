<?php
session_start();
require 'koneksi.php'; // File koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal_kegiatan'];
    $deskripsi = $_POST['deskripsi_kegiatan'];

    // Proses upload foto
    $foto_nama = $_FILES['foto_kegiatan']['name'];
    $foto_tmp = $_FILES['foto_kegiatan']['tmp_name'];
    $folder_upload = "uploads/";

    if (!is_dir($folder_upload)) {
        mkdir($folder_upload, 0777, true);
    }

    $foto_path = $folder_upload . basename($foto_nama);
    move_uploaded_file($foto_tmp, $foto_path);

    $query = "INSERT INTO kegiatan (tanggal_kegiatan, deskripsi_kegiatan, foto_kegiatan)
              VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $tanggal, $deskripsi, $foto_path);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect ke adminpage.php setelah berhasil
        header("Location: adminpage.php");
        exit();
    } else {
        echo "Gagal menambahkan kegiatan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kegiatan</title>
</head>
<body>
    <h2>Form Tambah Kegiatan</h2>
    <form action="tambah_kegiatan.php" method="POST" enctype="multipart/form-data">
        <label for="tanggal_kegiatan">Tanggal Kegiatan:</label><br>
        <input type="date" name="tanggal_kegiatan" required><br><br>

        <label for="deskripsi_kegiatan">Deskripsi:</label><br>
        <textarea name="deskripsi_kegiatan" rows="5" cols="40" placeholder="Masukkan deskripsi kegiatan..."></textarea><br><br>

        <label for="foto_kegiatan">Unggah Foto:</label><br>
        <input type="file" name="foto_kegiatan" accept="image/*"><br><br>

        <input type="submit" value="Simpan Kegiatan">
    </form>
</body>
</html>
