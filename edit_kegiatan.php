<?php
session_start();
require 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID kegiatan tidak ditemukan.";
    exit();
}

$id_kegiatan = $_GET['id'];

// Ambil data kegiatan berdasarkan ID
$query = "SELECT * FROM kegiatan WHERE id_kegiatan = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_kegiatan);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {
    echo "Kegiatan tidak ditemukan.";
    exit();
}

$data = mysqli_fetch_assoc($result);

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal_kegiatan'];
    $deskripsi = $_POST['deskripsi_kegiatan'];

    // Cek apakah pengguna mengganti foto
    if ($_FILES['foto_kegiatan']['name'] !== "") {
        $foto_nama = $_FILES['foto_kegiatan']['name'];
        $foto_tmp = $_FILES['foto_kegiatan']['tmp_name'];
        $folder_upload = "uploads/";

        if (!is_dir($folder_upload)) {
            mkdir($folder_upload, 0777, true);
        }

        $foto_path = $folder_upload . basename($foto_nama);
        move_uploaded_file($foto_tmp, $foto_path);
    } else {
        $foto_path = $data['foto_kegiatan']; // Gunakan foto lama jika tidak diganti
    }

    $updateQuery = "UPDATE kegiatan SET tanggal_kegiatan = ?, deskripsi_kegiatan = ?, foto_kegiatan = ? WHERE id_kegiatan = ?";
    $stmtUpdate = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmtUpdate, "sssi", $tanggal, $deskripsi, $foto_path, $id_kegiatan);

    if (mysqli_stmt_execute($stmtUpdate)) {
        header("Location: adminpage.php");
        exit();
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kegiatan</title>
</head>
<body>
    <h2>Edit Data Kegiatan</h2>
    <form action="edit_kegiatan.php?id=<?= $id_kegiatan ?>" method="POST" enctype="multipart/form-data">
        <label for="tanggal_kegiatan">Tanggal Kegiatan:</label><br>
        <input type="date" name="tanggal_kegiatan" value="<?= $data['tanggal_kegiatan'] ?>" required><br><br>

        <label for="deskripsi_kegiatan">Deskripsi:</label><br>
        <textarea name="deskripsi_kegiatan" rows="5" cols="40"><?= $data['deskripsi_kegiatan'] ?></textarea><br><br>

        <label for="foto_kegiatan">Foto Kegiatan:</label><br>
        <img src="<?= $data['foto_kegiatan'] ?>" width="150" alt="Foto saat ini"><br><br>
        <input type="file" name="foto_kegiatan" accept="image/*"><br><br>

        <input type="submit" value="Simpan Perubahan">
    </form>
</body>
</html>
