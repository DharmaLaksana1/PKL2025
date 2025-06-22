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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin_style.css"> <!-- Pastikan file ini ada -->
</head>
<body style="background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Tambah Data Pendidik</h2>
            </div>
            <div class="card-body">
                <form action="tambah_pendidik.php" method="POST" enctype="multipart/form-data">

                    <!-- Nama -->
                    <div class="form-group">
                        <label for="nama_pendidik">Nama Pendidik</label>
                        <input type="text" class="form-control" name="nama_pendidik" required>
                    </div>

                    <!-- Jabatan -->
                    <div class="form-group">
                        <label for="jabatan_pendidik">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan_pendidik" required>
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group">
                        <label for="deskripsi_pendidik">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi_pendidik" rows="5" placeholder="Masukkan deskripsi..."></textarea>
                    </div>

                    <!-- Foto -->
                    <div class="form-group">
                        <label for="foto_pendidik">Unggah Foto</label>
                        <input type="file" class="form-control-file" name="foto_pendidik" accept="image/*">
                    </div>

                    <!-- Tombol -->
                    <div class="form-group mt-4">
                        <input type="submit" value="Simpan Pendidik" class="btn btn-add">
                        <a href="adminpage.php" class="btn btn-add">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>
