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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin_style.css"> <!-- pastikan ini file CSS kamu -->
</head>
<body style="background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Tambah Kegiatan</h2>
            </div>
            <div class="card-body">
                <form action="tambah_kegiatan.php" method="POST" enctype="multipart/form-data">
                    
                    <!-- Tanggal -->
                    <div class="form-group">
                        <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
                        <input type="date" class="form-control" name="tanggal_kegiatan" required>
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group">
                        <label for="deskripsi_kegiatan">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi_kegiatan" rows="5" placeholder="Masukkan deskripsi kegiatan..."></textarea>
                    </div>

                    <!-- Foto -->
                    <div class="form-group">
                        <label for="foto_kegiatan">Unggah Foto</label>
                        <input type="file" class="form-control-file" name="foto_kegiatan" accept="image/*">
                    </div>

                    <!-- Tombol -->
                    <div class="form-group mt-4">
                        <input type="submit" value="Simpan Kegiatan" class="btn btn-add">
                        <a href="adminpage.php" class="btn btn-add">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>
