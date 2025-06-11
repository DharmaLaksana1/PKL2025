<?php
session_start();
require 'koneksi.php'; // Pastikan koneksi $conn sudah benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_pendidik'];
    $jabatan = $_POST['jabatan_pendidik'];
    $deskripsi = $_POST['deskripsi_pendidik'];

    // Proses upload foto
    $foto_nama = $_FILES['foto_pendidik']['name'];
    $foto_tmp = $_FILES['foto_pendidik']['tmp_name'];
    $folder_upload = "uploads_pendidik/";

    // Cek dan buat folder jika belum ada
    if (!is_dir($folder_upload)) {
        mkdir($folder_upload, 0777, true);
    }

    $foto_path = $folder_upload . basename($foto_nama);
    move_uploaded_file($foto_tmp, $foto_path);

    $query = "INSERT INTO pendidik (nama_pendidik, jabatan_pendidik, deskripsi_pendidik, foto_pendidik)
              VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $nama, $jabatan, $deskripsi, $foto_path);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: adminpage.php"); // Redirect ke adminpage setelah sukses
        exit();
    } else {
        echo "Gagal menambahkan pendidik: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pendidik</title>
</head>
<body>
    <h2>Form Tambah Pendidik</h2>
    <form action="tambah_pendidik.php" method="POST" enctype="multipart/form-data">
        <label for="nama_pendidik">Nama Pendidik:</label><br>
        <input type="text" name="nama_pendidik" required><br><br>

        <label for="jabatan_pendidik">Jabatan:</label><br>
        <input type="text" name="jabatan_pendidik" required><br><br>

        <label for="deskripsi_pendidik">Deskripsi:</label><br>
        <textarea name="deskripsi_pendidik" rows="5" cols="40" placeholder="Masukkan deskripsi..."></textarea><br><br>

        <label for="foto_pendidik">Unggah Foto:</label><br>
        <input type="file" name="foto_pendidik" accept="image/*"><br><br>

        <input type="submit" value="Simpan Pendidik">
    </form>
</body>
</html>
