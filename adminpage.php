<?php
session_start(); // Mulai sesi
include 'koneksi.php'; // Menyertakan file koneksi.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_kegiatan'])) {
        $kegiatanId = $_POST['id_kegiatan'];
        $deleteQuery = "DELETE FROM kegiatan WHERE id_kegiatan = ?";
        $stmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($stmt, 'i', $kegiatanId);
        mysqli_stmt_execute($stmt);

    } elseif (isset($_POST['delete_pencapaian'])) {
        $pencapaianId = $_POST['id_pencapaian'];
        $deleteQuery = "DELETE FROM pencapaian WHERE id_pencapaian = ?";
        $stmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($stmt, 'i', $pencapaianId);
        mysqli_stmt_execute($stmt);
    
    } elseif (isset($_POST['delete_pengurus'])) {
        $pengurusId = $_POST['id_pengurus'];
        $deleteQuery = "DELETE FROM pengurus WHERE id_pengurus = ?";
        $stmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($stmt, 'i', $pengurusId);
        mysqli_stmt_execute($stmt);
    
    } elseif (isset($_POST['delete_pendidik'])) {
        $pendidikId = $_POST['id_pendidik'];
        $deleteQuery = "DELETE FROM pendidik WHERE id_pendidik = ?";
        $stmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($stmt, 'i', $pendidikId);
        mysqli_stmt_execute($stmt);
    }
    
    header('Location: adminpage.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style2.css" media="screen" title="no title">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="css/style3.css">
    <style>
        
        .sidenav a.fas.fa-tools {
            color: green;
        }

        button.fas.fa-trash:hover {
            color: darkred;
        }

    </style>
</head>

<body>

<div id="main">
    <div id="user-operator-container">
    <?php
    
    $queryKegiatan = "SELECT * FROM kegiatan";
    $resultKegiatan = mysqli_query($conn, $queryKegiatan);

    $queryPencapaian = "SELECT * FROM pencapaian";
    $resultPencapaian = mysqli_query($conn, $queryPencapaian);

    $queryPendidik = "SELECT * FROM pendidik";
    $resultPendidik = mysqli_query($conn, $queryPendidik);

    $queryPengurus = "SELECT * FROM pengurus";
    $resultPengurus = mysqli_query($conn, $queryPengurus);
    
    if (mysqli_num_rows($resultKegiatan) > 0) {
        echo '<h2>Daftar Kegiatan</h2>';
        echo '<table>';
        echo '<tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Foto</th>
                <th>Aksi</th>
              </tr>';

        $no = 1;
        while ($row = mysqli_fetch_assoc($resultKegiatan)) {
            echo '<tr>';
            echo '<td>' . $no . '</td>';
            echo '<td>' . $row['tanggal_kegiatan'] . '</td>';
            echo '<td>' . $row['deskripsi_kegiatan'] . '</td>';
            echo '<td><img src="' . $row['foto_kegiatan'] . '" alt="Foto" style="max-width: 100px;"></td>';
            echo '<td>
                    <a href="edit_Kegiatan.php?id=' . $row['id_kegiatan'] . '" class="fas fa-edit"> Edit</a>
                    <form method="POST" action="adminpage.php" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus kegiatan ini?\');">
                        <input type="hidden" name="id_kegiatan" value="' . $row['id_kegiatan'] . '">
                        <button type="submit" name="delete_kegiatan" class="fas fa-trash">Hapus</button>
                    </form>
                  </td>';
            echo '</tr>';
            $no++;
        }
        echo '</table>';
        echo '<a href="tambah_Kegiatan.php" class="fas fa-plus"> Tambah Kegiatan</a>';

    } else {
        echo 'Tidak ada data kegiatan.';
    }

    if (mysqli_num_rows($resultPengurus) > 0) {
        echo '<h2>Daftar Pengurus</h2>';
        echo '<table>';
        echo '<tr>
                <th>No.</th>
                <th>Nama Pengurus</th>
                <th>Jabatan Pengurus</th>
                <th>Foto Pengurus</th>
                <th>Deskripsi Pengurus</th>
                <th>Aksi</th>
              </tr>';

        $no = 1;
        while ($row = mysqli_fetch_assoc($resultPengurus)) {
            echo '<tr>';
            echo '<td>' . $no . '</td>';
            echo '<td>' . $row['nama_pengurus'] . '</td>';
            echo '<td>' . $row['jabatan_pengurus'] . '</td>';
            echo '<td>' . $row['deskripsi_pengurus'] . '</td>';
            echo '<td><img src="' . $row['foto_pengurus'] . '" alt="Foto Pengurus" style="max-width: 100px;"></td>';
            echo '<td>
                    <a href="edit_pengurus.php?id=' . $row['id_pengurus'] . '" class="fas fa-edit"> Edit</a>
                    <form method="POST" action="adminpage.php" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus pengurus ini?\');">
                        <input type="hidden" name="id_pengurus" value="' . $row['id_pengurus'] . '">
                        <button type="submit" name="delete_pengurus" class="fas fa-trash">Hapus</button>
                    </form>
                  </td>';
            echo '</tr>';
            $no++;
        }
        echo '</table>';
        echo '<a href="tambah_Pengurus.php" class="fas fa-plus"> Tambah Pengurus</a>';

    } else {
        echo 'Tidak ada data pengurus.';
    }

        if (mysqli_num_rows($resultPencapaian) > 0) {
        echo '<h2>Daftar Pencapaian</h2>';
        echo '<table>';
        echo '<tr>
                <th>No.</th>
                <th>Judul Pencapaian</th>
                <th>Foto Pencapaian</th>
                <th>Deskripsi Pencapaian</th>
                <th>Aksi</th>
              </tr>';

        $no = 1;
        while ($row = mysqli_fetch_assoc($resultPencapaian)) {
            echo '<tr>';
            echo '<td>' . $no . '</td>';
            echo '<td>' . $row['judul_pencapaian'] . '</td>'; // pastikan kolom ini benar
            echo '<td><img src="' . $row['foto_pencapaian'] . '" alt="Foto Pencapaian" style="max-width: 100px;"></td>';
            echo '<td>' . $row['deskripsi_pencapaian'] . '</td>';
            echo '<td>
                    <a href="edit_pencapaian.php?id=' . $row['id_pencapaian'] . '" class="fas fa-edit"> Edit</a>
                    <form method="POST" action="adminpage.php" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus pencapaian ini?\');">
                        <input type="hidden" name="id_pencapaian" value="' . $row['id_pencapaian'] . '">
                        <button type="submit" name="delete_pencapaian" class="fas fa-trash">Hapus</button>
                    </form>
                  </td>';
            echo '</tr>';
            $no++;
        }
        echo '</table>';
        echo '<a href="tambah_Pencapaian.php" class="fas fa-plus"> Tambah Pencapaian</a>';
    } else {
    echo 'Tidak ada data pencapaian.';
}

    if (mysqli_num_rows($resultPendidik) > 0) {
        echo '<h2>Daftar Pendidik</h2>';
        echo '<table>';
        echo '<tr>
                <th>No.</th>
                <th>Nama Pendidik</th>
                <th>Jabatan Pendidik</th>
                <th>Foto Pendidik</th>
                <th>Deskripsi Pendidik</th>
                <th>Aksi</th>
              </tr>';

        $no = 1;
        while ($row = mysqli_fetch_assoc($resultPendidik)) {
            echo '<tr>';
            echo '<td>' . $no . '</td>';
            echo '<td>' . $row['nama_pendidik'] . '</td>';
            echo '<td>' . $row['jabatan_pendidik'] . '</td>';
            echo '<td>' . $row['deskripsi_pendidik'] . '</td>';
            echo '<td><img src="' . $row['foto_pendidik'] . '" alt="Foto Pendidik" style="max-width: 100px;"></td>';
            echo '<td>
                    <a href="edit_pendidik.php?id=' . $row['id_pendidik'] . '" class="fas fa-edit"> Edit</a>
                    <form method="POST" action="adminpage.php" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus pendidik ini?\');">
                        <input type="hidden" name="id_pendidik" value="' . $row['id_pendidik'] . '">
                        <button type="submit" name="delete_pendidik" class="fas fa-trash">Hapus</button>
                    <form method="POST" action="adminpage.php" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus pendidik ini?\');">
                        <input type="hidden" name="id_pendidik" value="' . $row['id_pendidik'] . '">
                        <button type="submit" name="delete_pendidik" class="fas fa-trash"></button>
                    </form>
                  </td>';
            echo '</tr>';
            $no++;
        }
        echo '</table>';
        echo '<a href="tambah_Pendidik.php" class="fas fa-plus"> Tambah Pendidik</a>';
    } else {
        echo 'Tidak ada data pendidik.';
    }
    ?>
        
    </div>  
    
</div>



<script>
function getConfirmation(){
    var retval = confirm ("apakah anda yakin ingin keluar?");
    if(retval == true){
        window.location.href ="index.html"
        return true;
    }else{
        window.location.href ="adminpage.php"
        return false;
    }   
}
</script>

<script src="script.js"></script>

</body>
</html>
