<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (empty($_SESSION['username'])) {
    header("Location: loginAdmin.php");
    exit;
}

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <link rel="stylesheet" href="assets/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendors/fontawesome/css/all.css">
    <link rel="stylesheet" href="assets/css/admin_style.css"> 
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">

</head>
<body>

<div class="d-flex" id="wrapper">
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">Admin Dashboard</div>
        <div class="list-group list-group-flush">
            <a href="#kegiatan-section" class="list-group-item list-group-item-action">
                <i class="fas fa-calendar-alt mr-2"></i> Kegiatan
            </a>
            <a href="#pengurus-section" class="list-group-item list-group-item-action">
                <i class="fas fa-users mr-2"></i> Pengurus
            </a>
            <a href="#pencapaian-section" class="list-group-item list-group-item-action">
                <i class="fas fa-trophy mr-2"></i> Pencapaian
            </a>
            <a href="#pendidik-section" class="list-group-item list-group-item-action">
                <i class="fas fa-chalkboard-teacher mr-2"></i> Pendidik
            </a>
            <a href="logout.php" class="list-group-item list-group-item-action text-danger"
            onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>

        </div>
    </div>
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <button class="btn btn-primary" id="menu-toggle"><i class="fas fa-bars"></i> Toggle Menu</button>
        </nav>

        <div class="container-fluid">
            <h1 class="mt-4 mb-4">Panel Administrasi</h1>

            <!-- ======================= BAGIAN KEGIATAN ======================= -->
            <section id="kegiatan-section">
                <div class="card">
                    <div class="card-header">
                        <h2>Daftar Kegiatan</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        $queryKegiatan = "SELECT * FROM kegiatan";
                        $resultKegiatan = mysqli_query($conn, $queryKegiatan);

                        if (mysqli_num_rows($resultKegiatan) > 0) {
                            echo '<div class="table-responsive">';
                            echo '<table class="table table-bordered table-hover">';
                            echo '<thead class="thead-light"><tr>
                                    <th>No.</th>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                  </tr></thead><tbody>';

                            $no = 1;
                            while ($row = mysqli_fetch_assoc($resultKegiatan)) {
                                echo '<tr>';
                                echo '<td>' . $no . '</td>';
                                echo '<td>' . htmlspecialchars($row['judul_kegiatan']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['tanggal_kegiatan']) . '</td>';
                                echo '<td>' . htmlspecialchars(substr($row['deskripsi_kegiatan'], 0, 100)) . '...</td>';

                                echo '<td>';
                                if (!empty($row['foto_kegiatan']) && file_exists($row['foto_kegiatan'])) {
                                    echo '<img src="' . htmlspecialchars($row['foto_kegiatan']) . '" alt="Foto Kegiatan">';
                                } else {
                                    echo 'No Image';
                                }
                                echo '</td>';

                                echo '<td>
                                        <a href="edit_kegiatan.php?id=' . htmlspecialchars($row['id_kegiatan']) . '" class="btn btn-sm btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                        <form method="POST" action="adminpage.php" 
                                            onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus kegiatan ini?\');" 
                                            style="display:inline-block;">
                                            
                                            <input type="hidden" name="id_kegiatan" value="' . htmlspecialchars($row['id_kegiatan']) . '">
                                            <button type="submit" name="delete_kegiatan" 
                                                class="btn btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
                                        </form>
                                      </td>';
                                echo '</tr>';
                                $no++;
                            }

                            echo '</tbody></table>';
                            echo '</div>';

                            echo '<a href="tambah_Kegiatan.php" class="btn btn-add"><i class="fas fa-plus"></i> Tambah Kegiatan</a>';
                        } else {
                            echo '<div class="alert alert-info" role="alert">Tidak ada data kegiatan.</div>';
                            echo '<a href="tambah_Kegiatan.php" class="btn btn-add"><i class="fas fa-plus"></i> Tambah Kegiatan</a>';
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- ======================= BAGIAN PENGURUS ======================= -->
            <section id="pengurus-section">
                <div class="card">
                    <div class="card-header">
                        <h2>Daftar Pengurus</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        $queryPengurus = "SELECT * FROM pengurus";
                        $resultPengurus = mysqli_query($conn, $queryPengurus);

                        if (mysqli_num_rows($resultPengurus) > 0) {
                            echo '<div class="table-responsive">';
                            echo '<table class="table table-bordered table-hover">';
                            echo '<thead class="thead-light"><tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Deskripsi</th>
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                  </tr></thead><tbody>';

                            $no = 1;
                            while ($row = mysqli_fetch_assoc($resultPengurus)) {
                                echo '<tr>';
                                echo '<td>' . $no . '</td>';
                                echo '<td>' . htmlspecialchars($row['nama_pengurus']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['jabatan_pengurus']) . '</td>';
                                echo '<td>' . htmlspecialchars(substr($row['deskripsi_pengurus'], 0, 100)) . '...</td>';

                                echo '<td>';
                                if (!empty($row['foto_pengurus']) && file_exists($row['foto_pengurus'])) {
                                    echo '<img src="' . htmlspecialchars($row['foto_pengurus']) . '" alt="Foto Pengurus">';
                                } else {
                                    echo 'No Image';
                                }
                                echo '</td>';

                                echo '<td>
                                        <a href="edit_pengurus.php?id=' . htmlspecialchars($row['id_pengurus']) . '" 
                                            class="btn btn-sm btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                        
                                        <form method="POST" action="adminpage.php" 
                                            onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus pengurus ini?\');" 
                                            style="display:inline-block;">

                                            <input type="hidden" name="id_pengurus" value="' . htmlspecialchars($row['id_pengurus']) . '">
                                            <button type="submit" name="delete_pengurus" 
                                                class="btn btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
                                        </form>
                                      </td>';

                                echo '</tr>';
                                $no++;
                            }

                            echo '</tbody></table>';
                            echo '</div>';
                            echo '<a href="tambah_Pengurus.php" class="btn btn-add"><i class="fas fa-plus"></i> Tambah Pengurus</a>';
                        } else {
                            echo '<div class="alert alert-info">Tidak ada data pengurus.</div>';
                            echo '<a href="tambah_Pengurus.php" class="btn btn-add"><i class="fas fa-plus"></i> Tambah Pengurus</a>';
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- ======================= BAGIAN PENCAPAIAN ======================= -->
            <section id="pencapaian-section">
                <div class="card">
                    <div class="card-header">
                        <h2>Daftar Pencapaian</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        $queryPencapaian = "SELECT * FROM pencapaian";
                        $resultPencapaian = mysqli_query($conn, $queryPencapaian);

                        if (mysqli_num_rows($resultPencapaian) > 0) {
                            echo '<div class="table-responsive">';
                            echo '<table class="table table-bordered table-hover">';
                            echo '<thead class="thead-light"><tr>
                                    <th>No.</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                  </tr></thead><tbody>';

                            $no = 1;
                            while ($row = mysqli_fetch_assoc($resultPencapaian)) {
                                echo '<tr>';
                                echo '<td>' . $no . '</td>';
                                echo '<td>' . htmlspecialchars($row['judul_pencapaian']) . '</td>';
                                echo '<td>' . htmlspecialchars(substr($row['deskripsi_pencapaian'], 0, 100)) . '...</td>';

                                echo '<td>';
                                if (!empty($row['foto_pencapaian']) && file_exists($row['foto_pencapaian'])) {
                                    echo '<img src="' . htmlspecialchars($row['foto_pencapaian']) . '" alt="Foto Pencapaian">';
                                } else {
                                    echo 'No Image';
                                }
                                echo '</td>';

                                echo '<td>
                                        <a href="edit_pencapaian.php?id=' . htmlspecialchars($row['id_pencapaian']) . '" class="btn btn-sm btn-edit"><i class="fas fa-edit"></i> Edit</a>

                                        <form method="POST" action="adminpage.php" 
                                            onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus pencapaian ini?\');" 
                                            style="display:inline-block;">

                                            <input type="hidden" name="id_pencapaian" value="' . htmlspecialchars($row['id_pencapaian']) . '">
                                            <button type="submit" name="delete_pencapaian" 
                                                class="btn btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
                                        </form>
                                      </td>';

                                echo '</tr>';
                                $no++;
                            }

                            echo '</tbody></table>';
                            echo '</div>';
                            echo '<a href="tambah_pencapaian.php" class="btn btn-add"><i class="fas fa-plus"></i> Tambah Pencapaian</a>';
                        } else {
                            echo '<div class="alert alert-info">Tidak ada data pencapaian.</div>';
                            echo '<a href="tambah_pencapaian.php" class="btn btn-add"><i class="fas fa-plus"></i> Tambah Pencapaian</a>';
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- ======================= BAGIAN PENDIDIK ======================= -->
            <section id="pendidik-section">
                <div class="card">
                    <div class="card-header">
                        <h2>Daftar Pendidik</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        $queryPendidik = "SELECT * FROM pendidik";
                        $resultPendidik = mysqli_query($conn, $queryPendidik);

                        if (mysqli_num_rows($resultPendidik) > 0) {
                            echo '<div class="table-responsive">';
                            echo '<table class="table table-bordered table-hover">';
                            echo '<thead class="thead-light"><tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Deskripsi</th>
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                  </tr></thead><tbody>';

                            $no = 1;
                            while ($row = mysqli_fetch_assoc($resultPendidik)) {
                                echo '<tr>';
                                echo '<td>' . $no . '</td>';
                                echo '<td>' . htmlspecialchars($row['nama_pendidik']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['jabatan_pendidik']) . '</td>';
                                echo '<td>' . htmlspecialchars(substr($row['deskripsi_pendidik'], 0, 100)) . '...</td>';

                                echo '<td>';
                                if (!empty($row['foto_pendidik']) && file_exists($row['foto_pendidik'])) {
                                    echo '<img src="' . htmlspecialchars($row['foto_pendidik']) . '" alt="Foto Pendidik">';
                                } else {
                                    echo 'No Image';
                                }
                                echo '</td>';

                                echo '<td>
                                        <a href="edit_pendidik.php?id=' . htmlspecialchars($row['id_pendidik']) . '" 
                                            class="btn btn-sm btn-edit"><i class="fas fa-edit"></i> Edit</a>

                                        <form method="POST" action="adminpage.php" 
                                            onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus pendidik ini?\');" 
                                            style="display:inline-block;">

                                            <input type="hidden" name="id_pendidik" value="' . htmlspecialchars($row['id_pendidik']) . '">
                                            <button type="submit" name="delete_pendidik" 
                                                class="btn btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
                                        </form>
                                      </td>';

                                echo '</tr>';
                                $no++;
                            }

                            echo '</tbody></table>';
                            echo '</div>';
                            echo '<a href="tambah_pendidik.php" class="btn btn-add"><i class="fas fa-plus"></i> Tambah Pendidik</a>';
                        } else {
                            echo '<div class="alert alert-info">Tidak ada data pendidik.</div>';
                            echo '<a href="tambah_pendidik.php" class="btn btn-add"><i class="fas fa-plus"></i> Tambah Pendidik</a>';
                        }
                        ?>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

<script src="assets/vendors/jquery/jquery.min.js"></script>
<script src="assets/vendors/bootstrap/js/popper.js"></script>
<script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/script.js"></script>

<script>
    $(document).ready(function() {
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    });

    function getConfirmation(){
        var retval = confirm ("Apakah Anda yakin ingin keluar?");
        if(retval == true){
            window.location.href ="index.html";
            return true;
        }else{
            return false;
        }   
    }
</script>

</body>
</html>
