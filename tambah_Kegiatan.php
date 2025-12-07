<?php
session_start();
require 'koneksi.php'; // Ganti dengan koneksi ke database kamu

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul_kegiatan']; 
    $tanggal = $_POST['tanggal_kegiatan'];
    $deskripsi = $_POST['deskripsi_kegiatan'];
    $base64_image = $_POST['cropped_image'];
    $file_path = '';

    if (strpos($base64_image, 'data:image') === 0) {
        $folder_upload = 'uploads/';

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

    $query = "INSERT INTO kegiatan (judul_kegiatan, tanggal_kegiatan, deskripsi_kegiatan, foto_kegiatan)
              VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $judul, $tanggal, $deskripsi, $file_path);

    if (mysqli_stmt_execute($stmt)) {
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
</head>

<body style="background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Tambah Kegiatan</h2>
        </div>

        <div class="card-body">

            <form action="" method="POST" enctype="multipart/form-data">

                <!-- Judul -->
                <div class="form-group">
                    <label for="judul_kegiatan">Judul Kegiatan</label>
                    <input type="text" class="form-control" name="judul_kegiatan"
                           placeholder="Masukkan judul kegiatan..." required>
                </div>

                <!-- Tanggal -->
                <div class="form-group">
                    <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
                    <input type="date" class="form-control" name="tanggal_kegiatan" required>
                </div>

                <!-- Deskripsi -->
                <div class="form-group">
                    <label for="deskripsi_kegiatan">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi_kegiatan" rows="5"
                              placeholder="Masukkan deskripsi kegiatan..."></textarea>
                </div>

                <!-- Upload Foto -->
                <div class="form-group">
                    <label for="foto_kegiatan">Unggah Foto</label>
                    <input type="file" class="form-control-file" id="foto_kegiatan" accept="image/*">
                </div>

                <!-- Hidden Input -->
                <input type="hidden" name="cropped_image" id="cropped_image">

                <!-- Tombol -->
                <div class="form-group mt-4">
                    <input type="submit" value="Simpan Kegiatan" class="btn btn-success">
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
        <h5 class="modal-title">Crop Foto</h5>
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

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
let cropper;

$('#foto_kegiatan').on('change', function (e) {
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

$('#cropModal')
    .on('shown.bs.modal', function () {
        cropper = new Cropper(document.getElementById('cropImage'), {
            aspectRatio: 760 / 415,
            viewMode: 1,
        });
    })
    .on('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    });

$('#cropButton').on('click', function () {
    const canvas = cropper.getCroppedCanvas({
        width: 800,
        height: 450,
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
