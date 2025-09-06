<?php
$servername = "localhost";
$database   = "u336544492_ydl";
$username   = "u336544492_root";
$password   = "Ydl2024@pass";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Koneksi error : " . mysqli_connect_error());
} else {
    // echo "Koneksi berhasil"; // bisa dicoba dulu untuk testing
}
?>
