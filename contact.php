<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
  <!-- header -->
  <header> 
   

        <!-- Main Menu Start -->
       
        <div class="site-navigation main_menu menu-transparent" id="mainmenu-area">
            <?php include 'navbar.php'; ?>
        </div>

        
    </header>

    <section class="page-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-8">
                    <div class="title-block">
                        <h1>Contact Us</h1>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item"><a href="#">Home</a></li>
                            <li class="list-inline-item">/</li>
                            <li class="list-inline-item">Contact</li>
                        </ul>
                    </div>

                    <?php
if (isset($_GET['success'])) {
    if ($_GET['success'] == '1') {
        echo '<div class="alert alert-success contact__msg" role="alert" style="margin-top: 20px;">Pesan Anda telah berhasil dikirim! Kami akan segera menghubungi Anda.</div>';
    } elseif ($_GET['success'] == '0') {
        echo '<div class="alert alert-danger contact__msg" role="alert" style="margin-top: 20px;">Oops! Ada masalah saat mengirim pesan Anda. Pastikan semua kolom terisi dengan benar.</div>';
    }
}
?>

                </div>
            </div>
        </div>
    </section>

    <section class="map">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact section-padding">
        <div class="container">

            <div class="row align-items-center justify-content-center">
                <div class="col-lg-7 col-xl-7">
                    <div class="section-heading center-heading">
                        <span class="subheading">contact</span>
                        <h3>For more information about our courses, get in touch Demo</h3>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">

                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12 col-md-6">
                            <div class="contact-item">
                                <p>Email Us</p>
                                <h4>support@email.com</h4>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-6">
                            <div class="contact-item">
                                <p>Make a Call</p>
                                <h4>+45 234 345467</h4>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-6">
                            <div class="contact-item">
                                <p>Corporate Office</p>
                                <h4>Moon Street Light Avenue, 14/05 Jupiter, JP 80630</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <form class="contact__form form-row" method="post" action="mail.php" id="contactForm">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <textarea name="message" cols="30" rows="6" class="form-control" placeholder="Your Message" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mt-4">
                                <button class="btn btn-main" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
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
                            <li><span>Ph:</span>+(62) xxxxxxxxxx</li>
                            <li><span>Email:</span>xxxxx@gmail.com</li>
                            <li><span>Location:</span> Jl. Dr. Sujono, No. 15, Mataram, Lombok, NTB</li>
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
        <a href="#top-header" class="js-scroll-trigger scroll-to-top">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>

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