<?php
session_start();
require 'koneksi.php'; // Koneksi ke DB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul_pencapaian'];
    $deskripsi = $_POST['deskripsi_pencapaian'];
    $base64_image = $_POST['cropped_image'];
    $file_path = '';

    if (strpos($base64_image, 'data:image') === 0) {
        $folder_upload = 'uploads_pencapaian/';
        if (!is_dir($folder_upload)) {
            mkdir($folder_upload, 0777, true);
        }

        $image_parts = explode(";base64,", $base64_image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $filename = uniqid() . '.' . $image_type;
        $file_path = $folder_upload . $filename;
        file_put_contents($file_path, $image_base64);
    }

    $query = "INSERT INTO pencapaian (judul_pencapaian, deskripsi_pencapaian, foto_pencapaian)
              VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $judul, $deskripsi, $file_path);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: adminpage.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
</head>
<body style="background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Tambah Pencapaian</h2>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    
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

                    <!-- Upload Foto -->
                    <div class="form-group">
                        <label for="foto_pencapaian">Unggah Foto</label>
                        <input type="file" class="form-control-file" id="foto_pencapaian" accept="image/*">
                    </div>

                    <!-- Hidden input -->
                    <input type="hidden" name="cropped_image" id="cropped_image">

                    <!-- Tombol -->
                    <div class="form-group mt-4">
                        <input type="submit" value="Simpan Pencapaian" class="btn btn-success">
                        <a href="adminpage.php" class="btn btn-secondary">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal Crop -->
    <div class="modal fade" id="cropModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document" style="max-width: 800px;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Crop Foto Pencapaian</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <img id="cropImage" style="max-width: 100%;">
          </div>
          <div class="modal-footer">
            <button type="button" id="cropButton" class="btn btn-primary">Crop & Simpan</button>
          </div>
        </div>
      </div>
    </div>

    <!-- JS Cropper -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
    let cropper;
    $('#foto_pencapaian').on('change', function (e) {
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
            aspectRatio: 370 / 229, // Rasio 370:229
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
            width: 370,
            height: 229,
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