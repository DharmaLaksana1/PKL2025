<?php
session_start();
require 'koneksi.php';   // sambungkan ke database
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="description" content="Education LMS template by Dreambuzz">
  <meta name="keywords" content="Eduhash,education,lms,seo,course,online,learning,coach,training,tutor">
  <meta name="author" content="themeturn.com">

  <title>Yayasan Dharma Laksana - Kegiatan Kami</title>

  <!-- Mobile Specific Meta-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="assets/vendors/bootstrap/bootstrap.css">
  <!-- Iconfont Css -->
  <link rel="stylesheet" href="assets/vendors/fontawesome/css/all.css">
  <link rel="stylesheet" href="assets/vendors/flaticon/flaticon.css">
  <!-- animate.css -->
  <link rel="stylesheet" href="assets/vendors/animate-css/animate.css">
  <link rel="stylesheet" href="assets/vendors/owl/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/vendors/owl/assets/owl.theme.default.min.css">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
</head>

<body id="top-header">
  <!-- header -->
  <header> 
   

        <!-- Main Menu Start -->
       
        <div class="site-navigation main_menu menu-transparent" id="mainmenu-area">
            <?php include 'navbar.php'; ?>
        </div>

        
    </header>

  <!-- Page Header -->
  <section class="page-header">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-8">
          <div class="title-block">
            <h1>Kegiatan Kami</h1>
            <ul class="list-inline mb-0">
              <li class="list-inline-item"><a href="index.html">Home</a></li>
              <li class="list-inline-item">/</li>
              <li class="list-inline-item">Kegiatan Kami</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <div class="page-wrapper">
    <div class="container">
      <div class="row">
        <!-- List Kegiatan -->
<div class="col-lg-8 col-xl-8">
  <?php
  $sql   = "SELECT * FROM kegiatan ORDER BY tanggal_kegiatan DESC";
  $res   = mysqli_query($conn, $sql);
  if (mysqli_num_rows($res) > 0):
    while ($row = mysqli_fetch_assoc($res)):
  ?>
  <article class="blog-post-item mb-5">
    <div class="post-thumb">
      <img src="<?= htmlspecialchars($row['foto_kegiatan']) ?>"
           alt="Foto Kegiatan"
           class="img-fluid rounded shadow-sm">
    </div>

    <div class="post-item mt-4">
      <div class="post-meta mb-2">
        <span class="post-date">
          <i class="fa fa-calendar-alt mr-2"></i>
          <?= date('F j, Y', strtotime($row['tanggal_kegiatan'])) ?>
        </span>
      </div>

      <!-- JUDUL KEGIATAN -->
<h2 class="post-title" style="font-size: 26px; font-weight: 700; color:#333;">
  <?= htmlspecialchars($row['judul_kegiatan']) ?>
</h2>


      <!-- DESKRIPSI SINGKAT -->
      <div class="post-content mt-3">
        <p style="font-size: 15px; color:#555; line-height:1.6;">
          <?= nl2br(htmlspecialchars(substr($row['deskripsi_kegiatan'], 0, 180))) ?>…
        </p>
      </div>
    </div>
  </article>
  <?php
    endwhile;
  else:
  ?>
    <p>Tidak ada kegiatan untuk ditampilkan.</p>
  <?php endif; ?>

</div>


        <!-- Sidebar (kosong atau isi sesuai kebutuhan) -->
        <div class="col-lg-4 col-xl-4">
          <div class="blog-sidebar mt-5 mt-lg-0">
            <!-- Tambahkan widget/search/post terbaru dsb -->
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Footer -->
  <section class="footer-2">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-6 col-md-8">
          <div class="widget footer-about mb-4 text-center">
            <h5 class="widget-title text-gray">About us</h5>
            <ul class="list-unstyled footer-info">
              <li><span>Ph:</span>+(62) xxxxxxxxxx</li>
              <li><span>Email:</span>xxxxx@gmail.com</li>
              <li><span>Location:</span>Jl. Dr. Sujono, No. 15, Lingkar Selatan, Mataram, Lombok, NTB</li>
            </ul>
            <ul class="list-inline footer-socials">
              <li class="list-inline-item">Follow us :</li>
              <li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
              <li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
              <li class="list-inline-item"><a href="#"><i class="fab fa-linkedin"></i></a></li>
              <li class="list-inline-item"><a href="#"><i class="fab fa-pinterest"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="fixed-btm-top">
    <a href="#top-header" class="js-scroll-trigger scroll-to-top"><i class="fa fa-angle-up"></i></a>
  </div>

  <!-- Essential Scripts -->
  <script src="assets/vendors/jquery/jquery.js"></script>
  <script src="assets/vendors/bootstrap/bootstrap.js"></script>
  <script src="assets/vendors/counterup/waypoint.js"></script>
  <script src="assets/vendors/counterup/jquery.counterup.min.js"></script>
  <script src="assets/vendors/jquery.isotope.js"></script>
  <script src="assets/vendors/imagesloaded.js"></script>
  <script src="assets/vendors/owl/owl.carousel.min.js"></script>
  <script src="assets/vendors/google-map/map.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkeLMlsiwzp6b3Gnaxd86lvakimwGA6UA&callback=initMap"></script>
  <script src="assets/js/script.js"></script>
</body>
</html>
