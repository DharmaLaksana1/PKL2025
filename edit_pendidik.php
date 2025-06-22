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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin_style.css">
</head>
<body style="background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-header">
        <h2>Edit Data Pendidik</h2>
      </div>
      <div class="card-body">
        <form action="edit_pendidik.php?id=<?= $id_pendidik ?>" method="POST" enctype="multipart/form-data">
          
          <!-- Nama Pendidik -->
          <div class="form-group">
            <label for="nama_pendidik">Nama Pendidik</label>
            <input 
              type="text" 
              name="nama_pendidik" 
              class="form-control" 
              value="<?= $data['nama_pendidik'] ?>" 
              required>
          </div>

          <!-- Jabatan -->
          <div class="form-group">
            <label for="jabatan_pendidik">Jabatan</label>
            <input 
              type="text" 
              name="jabatan_pendidik" 
              class="form-control" 
              value="<?= $data['jabatan_pendidik'] ?>" 
              required>
          </div>

          <!-- Deskripsi -->
          <div class="form-group">
            <label for="deskripsi_pendidik">Deskripsi</label>
            <textarea 
              name="deskripsi_pendidik" 
              class="form-control" 
              rows="5"><?= $data['deskripsi_pendidik'] ?></textarea>
          </div>

          <!-- Foto -->
          <div class="form-group">
            <label for="foto_pendidik">Foto Pendidik Saat Ini</label><br>
            <img 
              src="<?= $data['foto_pendidik'] ?>" 
              width="150" 
              class="img-thumbnail mb-2" 
              alt="Foto Pendidik"><br>
            <input 
              type="file" 
              name="foto_pendidik" 
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
