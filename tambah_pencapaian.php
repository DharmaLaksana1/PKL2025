<?php
session_start();
require 'koneksi.php'; // Pastikan ini menghubungkan ke database $conn

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul_pencapaian'];
    $deskripsi = $_POST['deskripsi_pencapaian'];

    // Proses upload foto
    $foto_nama = $_FILES['foto_pencapaian']['name'];
    $foto_tmp = $_FILES['foto_pencapaian']['tmp_name'];
    $folder_upload = "uploads_pencapaian/";

    // Cek dan buat folder jika belum ada
    if (!is_dir($folder_upload)) {
        mkdir($folder_upload, 0777, true);
    }

    $foto_path = $folder_upload . basename($foto_nama);
    move_uploaded_file($foto_tmp, $foto_path);

    $query = "INSERT INTO pencapaian (judul_pencapaian, deskripsi_pencapaian, foto_pencapaian)
              VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $judul, $deskripsi, $foto_path);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: adminpage.php"); // Langsung redirect ke adminpage
        exit();
    } else {
        echo "Gagal menambahkan pencapaian: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pencapaian</title>
</head>
<body>
    <h2>Form Tambah Pencapaian</h2>
    <form action="tambah_pencapaian.php" method="POST" enctype="multipart/form-data">
        <label for="judul_pencapaian">Judul Pencapaian:</label><br>
        <input type="text" name="judul_pencapaian" required><br><br>

        <label for="deskripsi_pencapaian">Deskripsi:</label><br>
        <textarea name="deskripsi_pencapaian" rows="5" cols="40" placeholder="Masukkan deskripsi..."></textarea><br><br>

        <label for="foto_pencapaian">Unggah Foto:</label><br>
        <input type="file" name="foto_pencapaian" accept="image/*"><br><br>

        <input type="submit" value="Simpan Pencapaian">
    </form>
</body>
</html>
