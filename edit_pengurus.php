<?php
session_start();
require 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID pengurus tidak ditemukan.";
    exit();
}

$id_pengurus = $_GET['id'];

// Ambil data pengurus berdasarkan ID
$query = "SELECT * FROM pengurus WHERE id_pengurus = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_pengurus);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {
    echo "Data pengurus tidak ditemukan.";
    exit();
}

$data = mysqli_fetch_assoc($result);

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_pengurus'];
    $jabatan = $_POST['jabatan_pengurus'];
    $deskripsi = $_POST['deskripsi_pengurus'];

    // Cek apakah ada foto baru
    if ($_FILES['foto_pengurus']['name'] !== "") {
        $foto_nama = $_FILES['foto_pengurus']['name'];
        $foto_tmp = $_FILES['foto_pengurus']['tmp_name'];
        $folder_upload = "uploads_pengurus/";

        if (!is_dir($folder_upload)) {
            mkdir($folder_upload, 0777, true);
        }

        $foto_path = $folder_upload . basename($foto_nama);
        move_uploaded_file($foto_tmp, $foto_path);
    } else {
        $foto_path = $data['foto_pengurus']; // Tetap gunakan foto lama
    }

    $updateQuery = "UPDATE pengurus SET nama_pengurus = ?, jabatan_pengurus = ?, deskripsi_pengurus = ?, foto_pengurus = ? WHERE id_pengurus = ?";
    $stmtUpdate = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmtUpdate, "ssssi", $nama, $jabatan, $deskripsi, $foto_path, $id_pengurus);

    if (mysqli_stmt_execute($stmtUpdate)) {
        header("Location: adminpage.php");
        exit();
    } else {
        echo "Gagal memperbarui data pengurus: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengurus</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin_style.css">
</head>
<body style="background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-header">
        <h2>Edit Data Pengurus</h2>
      </div>
      <div class="card-body">
        <form action="edit_pengurus.php?id=<?= $id_pengurus ?>" method="POST" enctype="multipart/form-data">

          <!-- Nama Pengurus -->
          <div class="form-group">
            <label for="nama_pengurus">Nama Pengurus</label>
            <input
              type="text"
              name="nama_pengurus"
              class="form-control"
              value="<?= $data['nama_pengurus'] ?>"
              required>
          </div>

          <!-- Jabatan -->
          <div class="form-group">
            <label for="jabatan_pengurus">Jabatan</label>
            <input
              type="text"
              name="jabatan_pengurus"
              class="form-control"
              value="<?= $data['jabatan_pengurus'] ?>"
              required>
          </div>

          <!-- Deskripsi -->
          <div class="form-group">
            <label for="deskripsi_pengurus">Deskripsi</label>
            <textarea
              name="deskripsi_pengurus"
              class="form-control"
              rows="5"><?= $data['deskripsi_pengurus'] ?></textarea>
          </div>

          <!-- Foto -->
          <div class="form-group">
            <label for="foto_pengurus">Foto Pengurus Saat Ini</label><br>
            <img
              src="<?= $data['foto_pengurus'] ?>"
              width="150"
              class="img-thumbnail mb-2"
              alt="Foto Pengurus"><br>
            <input
              type="file"
              name="foto_pengurus"
              class="form-control-file"
              accept="image/*">
          </div>

          <!-- Tombol -->
          <div class="form-group mt-4">
                        <input type="submit" value="Simpan Perubahan" class="btn btn-add">
                        <a href="adminpage.php" class="btn btn-add">Batal</a>
                    </div>
          <div class="form-group mt-4">

        </form>
      </div>
    </div>
  </div>
</body>
</html>

</html>
