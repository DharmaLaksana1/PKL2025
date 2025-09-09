<?php
session_start(); // Mulai sesi

require "koneksi.php";

$email = $_POST["email"];
$password = $_POST["password"];

$query_sql = "SELECT * FROM Admin
              WHERE email_admin = '$email' AND sandi_admin = '$password'";

$result = mysqli_query($conn, $query_sql);

if (mysqli_num_rows($result) > 0){
    // Jika login berhasil, simpan username dalam sesi
    $row = mysqli_fetch_assoc($result);
    $_SESSION["username"] = $row["nama_admin"]; // Menggunakan nama_admin sebagai username
    header("location: beranda.php");
} else {
    echo "<center><h1>Email atau Password Anda Salah. Silahkan Coba Login Kembali.</h1>
            <button><strong><a href='loginAdmin.html'>Login</a></strong></button></center>";
}
?>
