<?php
session_start();
require 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID pendidik tidak ditemukan.";
    exit();
}

$id_pendidik = $_GET['id'];

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_pendidik'];
    $jabatan = $_POST['jabatan_pendidik'];
    $deskripsi = $_POST['deskripsi_pendidik'];
    $foto_path = $data['foto_pendidik'];

    if (!empty($_POST['cropped_image'])) {
        $base64_image = $_POST['cropped_image'];
        if (strpos($base64_image, 'data:image') === 0) {
            $folder_upload = 'uploads_pendidik/';
            if (!is_dir($folder_upload)) {
                mkdir($folder_upload, 0777, true);
            }

            $image_parts = explode(";base64,", $base64_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            $filename = uniqid() . '.' . $image_type;
            $foto_path = $folder_upload . $filename;
            file_put_contents($foto_path, $image_base64);
        }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
</head>
<body style="background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Edit Data Pendidik</h2>
        </div>
        <div class="card-body">
            <form action="edit_pendidik.php?id=<?= $id_pendidik ?>" method="POST" enctype="multipart/form-data">

                <!-- Nama -->
                <div class="form-group">
                    <label for="nama_pendidik">Nama Pendidik</label>
                    <input type="text" name="nama_pendidik" class="form-control" value="<?= $data['nama_pendidik'] ?>" required>
                </div>

                <!-- Jabatan -->
                <div class="form-group">
                    <label for="jabatan_pendidik">Jabatan</label>
                    <input type="text" name="jabatan_pendidik" class="form-control" value="<?= $data['jabatan_pendidik'] ?>" required>
                </div>

                <!-- Deskripsi -->
                <div class="form-group">
                    <label for="deskripsi_pendidik">Deskripsi</label>
                    <textarea name="deskripsi_pendidik" class="form-control" rows="5"><?= $data['deskripsi_pendidik'] ?></textarea>
                </div>

                <!-- Foto -->
                <div class="form-group">
                    <label for="foto_pendidik">Foto Saat Ini</label><br>
                    <img src="<?= $data['foto_pendidik'] ?>" width="150" class="img-thumbnail mb-2"><br>
                    <input type="file" id="foto_pendidik" class="form-control-file" accept="image/*">
                </div>

                <input type="hidden" name="cropped_image" id="cropped_image">

                <!-- Tombol -->
                <div class="form-group mt-4">
                    <input type="submit" value="Simpan Perubahan" class="btn btn-success">
                    <a href="adminpage.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="cropModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Foto</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <img id="cropImage" style="max-width: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" id="cropButton" class="btn btn-primary">Crop & Gunakan</button>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;
    $('#foto_pendidik').on('change', function (e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const reader = new FileReader();
            reader.onload = function (event) {
                $('#cropImage').attr('src', event.target.result);
                $('#cropModal').modal('show');
            };
            reader.readAsDataURL(files[0]);
        }
    });

    $('#cropModal').on('shown.bs.modal', function () {
        cropper = new Cropper(document.getElementById('cropImage'), {
            aspectRatio: 1,
            viewMode: 1,
        });
    }).on('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    });

    $('#cropButton').on('click', function () {
        const canvas = cropper.getCroppedCanvas({
            width: 500,
            height: 500,
        });

        canvas.toBlob(function (blob) {
            const reader = new FileReader();
            reader.onloadend = function () {
                $('#cropped_image').val(reader.result);
                $('#cropModal').modal('hide');
            };
            reader.readAsDataURL(blob);
        });
    });
</script>
</body>
</html>
