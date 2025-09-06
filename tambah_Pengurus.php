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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin_style.css"> <!-- Sesuaikan dengan file CSS kamu -->
</head>

<body style="background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Tambah Data Pengurus</h2>
            </div>
            <div class="card-body">
                <form action="tambah_Pengurus.php" method="POST" enctype="multipart/form-data">

                    <!-- Nama -->
                    <div class="form-group">
                        <label for="nama_pengurus">Nama Pengurus</label>
                        <input type="text" class="form-control" name="nama_pengurus" required>
                    </div>

                    <!-- Jabatan -->
                    <div class="form-group">
                        <label for="jabatan_pengurus">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan_pengurus" required>
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group">
                        <label for="deskripsi_pengurus">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi_pengurus" rows="5" placeholder="Masukkan deskripsi..."></textarea>
                    </div>

                    <!-- Foto -->
                    <div class="form-group">
                        <label for="foto_pengurus">Unggah Foto</label>
                        <input type="file" class="form-control-file" name="foto_pengurus" accept="image/*">
                    </div>

                    <!-- Tombol -->
                    <div class="form-group mt-4">
                        <input type="submit" value="Simpan Pengurus" class="btn btn-add">
                        <a href="adminpage.php" class="btn btn-add">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>
