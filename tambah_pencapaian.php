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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin_style.css"> <!-- pastikan file ini tersedia -->
</head>
<body style="background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Tambah Pencapaian</h2>
            </div>
            <div class="card-body">
                <form action="tambah_pencapaian.php" method="POST" enctype="multipart/form-data">
                    
                    <!-- Judul -->
                    <div class="form-group">
                        <label for="judul_pencapaian">Judul Pencapaian</label>
                        <input type="text" class="form-control" name="judul_pencapaian" required>
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group">
                        <label for="deskripsi_pencapaian">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi_pencapaian" rows="5" placeholder="Masukkan deskripsi..."></textarea>
                    </div>

                    <!-- Foto -->
                    <div class="form-group">
                        <label for="foto_pencapaian">Unggah Foto</label>
                        <input type="file" class="form-control-file" name="foto_pencapaian" accept="image/*">
                    </div>

                    <!-- Tombol -->
                    <div class="form-group mt-4">
                        <input type="submit" value="Simpan Pencapaian" class="btn btn-add">
                        <a href="adminpage.php" class="btn btn-add">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>
