<?php
session_start();
require 'koneksi.php';   // koneksi ke database
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="Education LMS template by Dreambuzz">
  <meta name="keywords" content="Eduhash,education,lms,seo,course,online,learning,caoch,training,tutor">
  <meta name="author" content="themeturn.com">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Yayasan Dharma Laksana</title>

  <!-- Stylesheets -->
  <link rel="stylesheet" href="assets/vendors/bootstrap/bootstrap.css">
  <link rel="stylesheet" href="assets/vendors/fontawesome/css/all.css">
  <link rel="stylesheet" href="assets/vendors/flaticon/flaticon.css">
  <link rel="stylesheet" href="assets/vendors/animate-css/animate.css">
  <link rel="stylesheet" href="assets/vendors/owl/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/vendors/owl/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
</head>

<body id="top-header">

<header>
  <div class="site-navigation main_menu menu-transparent" id="mainmenu-area">
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid container-padding">
        <a class="navbar-brand" href="index.php">
          <img src="assets/images/dark-logo.png" alt="Eduhash" class="img-fluid">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu">
          <span class="fa fa-bars"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a href="index.php" class="nav-link js-scroll-trigger">Dashboard</a></li>
            <li class="nav-item"><a href="index-2.php" class="nav-link js-scroll-trigger">Visi Misi</a></li>
            <li class="nav-item"><a href="about.php" class="nav-link js-scroll-trigger" style="color: #20ad96;">Tentang Kami</a></li>
            <li class="nav-item"><a href="blog.php" class="nav-link js-scroll-trigger">Kegiatan Kami</a></li>
            <li class="nav-item"><a href="contact.php" class="nav-link js-scroll-trigger">Hubungi Kami</a></li>
          </ul>
          <div class="d-flex align-items-center">
            <div class="header-socials social-links d-none d-lg-none d-xl-block">
              <a href="#"><i class="fab fa-facebook-f"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-linkedin"></i></a>
              <a href="#"><i class="fab fa-pinterest"></i></a>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</header>

<section class="page-header">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-8">
        <div class="title-block">
          <h1>YAYASAN DHARMA</h1>
          <ul class="list-inline mb-0">
            <li class="list-inline-item"><a href="#">Home</a></li>
            <li class="list-inline-item">/</li>
            <li class="list-inline-item">About Us</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="about-section section-padding">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-xl-6 col-lg-6">
        <div class="video-block">
          <img src="assets/images/bg/about.jpg" alt="" class="img-fluid">
          <a href="#"><i class="fa fa-play"></i></a>
        </div>
      </div>
      <div class="col-xl-6 pl-5 col-lg-6">
        <div class="section-heading mt-4 mt-lg-0 ">
          <span class="subheading">Tentang Kami</span>
          <h3>Yayasan Dharma Laksana</h3>
          <p>Yayasan Dharma Laksana Mataram (YDLM) merupakan lembaga pendidikan dan sosial berbasis Hindu yang berdiri sejak tahun 1992 di Kota Mataram, Nusa Tenggara Barat. Yayasan ini menjadi pusat pengembangan sumber daya manusia Hindu yang berdaya saing dan berkualitas, berlandaskan pada nilai-nilai Panca Sradha.</p>
        </div>
        <ul class="about-features">
          <li><i class="fa fa-check"></i><h5>Sekolah Dasar</h5></li>
          <li><i class="fa fa-check"></i><h5>Sekolah Menengah Pertama</h5></li>
          <li><i class="fa fa-check"></i><h5>Sekolah Menengah Atas</h5></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- <section class="counter-block">
    <div class="container">
        <div class="row" >
            <div class="col-xl-12 bg-black counter-inner">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter-item text-center">
                            <i class="flaticon-video-camera"></i>
                            <div class="count">
                                <span class="counter">90</span>
                            </div>
                            <h6>Pendidik</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter-item text-center">
                            <i class="flaticon-layers"></i>
                            <div class="count">
                                <span class="counter">1450</span>
                            </div>
                            <h6>Anak Didik</h6>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">         
                        <div class="counter-item text-center">
                            <i class="flaticon-flag"></i>
                            <div class="count">
                                <span class="counter">5697</span>
                            </div>
                            <h6>Alumnus</h6>
                        </div>
                    </div>
                
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter-item text-center border-0">
                            <i class="flaticon-help"></i>
                            <div class="count">
                                <span class="counter">10</span>
                            </div>
                            <h6>Cabang</h6>     
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>
</section> -->

<!-- TESTIMONIALS SECTION -->
<section class="testimonial section-padding">
  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="col-lg-7">
        <div class="section-heading center-heading">
          <span class="subheading">Profil Pendidik</span>
          <h3>Tim Pendidik Kami</h3>
          <p>Pendidik berdedikasi yang menjadi pilar utama dalam mencetak generasi unggul dan berkarakter.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid px-120">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="testimonials-slides owl-carousel owl-theme">
          <?php
$query = "SELECT * FROM pendidik";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="testimonial-item">
                <i class="fa fa-quote-right"></i>
                <div class="client-info">
                    <img src="' . htmlspecialchars($row["foto_pendidik"]) . '" alt="Foto Pendidik">
                    <div class="testionial-author">' . htmlspecialchars($row['nama_pendidik']) . '</div>
                </div>
                <div class="testimonial-info-title">
                    <h4>' . htmlspecialchars($row['jabatan_pendidik']) . '</h4>
                </div>
                <div class="testimonial-info-desc">' . nl2br(htmlspecialchars($row['deskripsi_pendidik'])) . '</div>
              </div>';
    }
} else {
    echo "<p class='text-center'>Belum ada data pendidik.</p>";
}
?>




        </div>
      </div>
    </div>
  </div>
</section>

<section class="cta bg-gray section-padding">
  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="col-lg-7">
        <div class="section-heading center-heading mb-0">
          <span class="subheading">BERGABUNG SEBAGAI PENGAJAR</span>
          <h3>Ingin Menjadi Pendidik di Yayasan Kami ?</h3>
          <p class="mb-4">Bergabunglah bersama para pendidik inspiratif dari berbagai daerah. Berbagi ilmu, membentuk masa depan, dan tumbuh bersama komunitas pembelajar yang berdedikasi. Mengajar kini semudah berinteraksi secara langsung.</p>
          <a href="#" class="btn btn-main">DAFTAR SEBAGAI PENGAJAR</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="footer-2">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-6 col-md-8">
        <div class="widget footer-about mb-4 text-center">
          <h5 class="widget-title text-gray">About us</h5>
          <ul class="list-unstyled footer-info">
            <li><span>Ph:</span>+(68) 345 5902</li>
            <li><span>Email:</span>info@yourdomain.com</li>
            <li><span>Location:</span> 123 Fifth Floor East 26th Street, New York, NY 10011</li>
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

  <div class="footer-btm">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-xl-6 col-lg-8 col-md-12">
          <div class="copyright text-lg-right text-center">
            <p>© Copyright EduHash Template. Crafted by <a href="https://themeturn.com">Dreambuzz</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="fixed-btm-top">
  <a href="#top-header" class="js-scroll-trigger scroll-to-top"><i class="fa fa-angle-up"></i></a>
</div>

<!-- JS Scripts -->
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
