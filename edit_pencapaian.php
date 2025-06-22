<?php
session_start();
require 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID pencapaian tidak ditemukan.";
    exit();
}

$id_pencapaian = $_GET['id'];

// Ambil data dari database
$query = "SELECT * FROM pencapaian WHERE id_pencapaian = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_pencapaian);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {
    echo "Data pencapaian tidak ditemukan.";
    exit();
}

$data = mysqli_fetch_assoc($result);

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul_pencapaian'];
    $deskripsi = $_POST['deskripsi_pencapaian'];

    // Cek apakah ada file foto baru
    if ($_FILES['foto_pencapaian']['name'] !== "") {
        $foto_nama = $_FILES['foto_pencapaian']['name'];
        $foto_tmp = $_FILES['foto_pencapaian']['tmp_name'];
        $folder_upload = "uploads_pencapaian/";

        if (!is_dir($folder_upload)) {
            mkdir($folder_upload, 0777, true);
        }

        $foto_path = $folder_upload . basename($foto_nama);
        move_uploaded_file($foto_tmp, $foto_path);
    } else {
        $foto_path = $data['foto_pencapaian']; // Gunakan foto lama
    }

    $updateQuery = "UPDATE pencapaian SET judul_pencapaian = ?, deskripsi_pencapaian = ?, foto_pencapaian = ? WHERE id_pencapaian = ?";
    $stmtUpdate = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmtUpdate, "sssi", $judul, $deskripsi, $foto_path, $id_pencapaian);

    if (mysqli_stmt_execute($stmtUpdate)) {
        header("Location: adminpage.php");
        exit();
    } else {
        echo "Gagal memperbarui data pencapaian: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pencapaian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin_style.css"> <!-- pastikan ini memuat CSS kamu -->
</head>
<body style="background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Edit Data Pencapaian</h2>
            </div>
            <div class="card-body">
                <form action="edit_pencapaian.php?id=<?= $id_pencapaian ?>" method="POST" enctype="multipart/form-data">
                    
                    <!-- Judul -->
                    <div class="form-group">
                        <label for="judul_pencapaian">Judul Pencapaian</label>
                        <input type="text" name="judul_pencapaian" class="form-control" value="<?= $data['judul_pencapaian'] ?>" required>
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group">
                        <label for="deskripsi_pencapaian">Deskripsi</label>
                        <textarea name="deskripsi_pencapaian" class="form-control" rows="5"><?= $data['deskripsi_pencapaian'] ?></textarea>
                    </div>

                    <!-- Foto -->
                    <div class="form-group">
                        <label for="foto_pencapaian">Foto Pencapaian Saat Ini</label><br>
                        <img src="<?= $data['foto_pencapaian'] ?>" width="150" class="img-thumbnail mb-2" alt="Foto Pencapaian"><br>
                        <input type="file" name="foto_pencapaian" class="form-control-file" accept="image/*">
                    </div>

                    <!-- Tombol -->
                    <div class="form-group mt-4">
                        <input type="submit" value="Simpan Perubahan" class="btn btn-add">
                        <a href="adminpage.php" class="btn btn-add">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
