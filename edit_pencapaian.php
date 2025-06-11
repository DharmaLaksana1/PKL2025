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
</head>
<body>
    <h2>Edit Data Pencapaian</h2>
    <form action="edit_pencapaian.php?id=<?= $id_pencapaian ?>" method="POST" enctype="multipart/form-data">
        <label for="judul_pencapaian">Judul Pencapaian:</label><br>
        <input type="text" name="judul_pencapaian" value="<?= $data['judul_pencapaian'] ?>" required><br><br>

        <label for="deskripsi_pencapaian">Deskripsi:</label><br>
        <textarea name="deskripsi_pencapaian" rows="5" cols="40"><?= $data['deskripsi_pencapaian'] ?></textarea><br><br>

        <label for="foto_pencapaian">Foto Pencapaian:</label><br>
        <img src="<?= $data['foto_pencapaian'] ?>" width="150" alt="Foto saat ini"><br><br>
        <input type="file" name="foto_pencapaian" accept="image/*"><br><br>

        <input type="submit" value="Simpan Perubahan">
    </form>
</body>
</html>
