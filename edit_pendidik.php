<?php
session_start();
require 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID pendidik tidak ditemukan.";
    exit();
}

$id_pendidik = $_GET['id'];

// Ambil data pendidik berdasarkan ID
$query = "SELECT * FROM pendidik WHERE id_pendidik = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_pendidik);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {
    echo "Data pendidik tidak ditemukan.";
    exit();
}

$data = mysqli_fetch_assoc($result);

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_pendidik'];
    $jabatan = $_POST['jabatan_pendidik'];
    $deskripsi = $_POST['deskripsi_pendidik'];

    // Cek apakah ada file foto baru
    if ($_FILES['foto_pendidik']['name'] !== "") {
        $foto_nama = $_FILES['foto_pendidik']['name'];
        $foto_tmp = $_FILES['foto_pendidik']['tmp_name'];
        $folder_upload = "uploads_pendidik/";

        if (!is_dir($folder_upload)) {
            mkdir($folder_upload, 0777, true);
        }

        $foto_path = $folder_upload . basename($foto_nama);
        move_uploaded_file($foto_tmp, $foto_path);
    } else {
        $foto_path = $data['foto_pendidik']; // Tetap gunakan foto lama jika tidak diubah
    }

    $updateQuery = "UPDATE pendidik SET nama_pendidik = ?, jabatan_pendidik = ?, deskripsi_pendidik = ?, foto_pendidik = ? WHERE id_pendidik = ?";
    $stmtUpdate = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmtUpdate, "ssssi", $nama, $jabatan, $deskripsi, $foto_path, $id_pendidik);

    if (mysqli_stmt_execute($stmtUpdate)) {
        header("Location: adminpage.php");
        exit();
    } else {
        echo "Gagal memperbarui data pendidik: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pendidik</title>
</head>
<body>
    <h2>Edit Data Pendidik</h2>
    <form action="edit_pendidik.php?id=<?= $id_pendidik ?>" method="POST" enctype="multipart/form-data">
        <label for="nama_pendidik">Nama Pendidik:</label><br>
        <input type="text" name="nama_pendidik" value="<?= $data['nama_pendidik'] ?>" required><br><br>

        <label for="jabatan_pendidik">Jabatan:</label><br>
        <input type="text" name="jabatan_pendidik" value="<?= $data['jabatan_pendidik'] ?>" required><br><br>

        <label for="deskripsi_pendidik">Deskripsi:</label><br>
        <textarea name="deskripsi_pendidik" rows="5" cols="40"><?= $data['deskripsi_pendidik'] ?></textarea><br><br>

        <label for="foto_pendidik">Foto Pendidik:</label><br>
        <img src="<?= $data['foto_pendidik'] ?>" width="150" alt="Foto saat ini"><br><br>
        <input type="file" name="foto_pendidik" accept="image/*"><br><br>

        <input type="submit" value="Simpan Perubahan">
    </form>
</body>
</html>
