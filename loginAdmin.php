<?php
session_start();
require "koneksi.php";

$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = mysqli_real_escape_string($conn, $_POST["password"]);

$query_sql = "SELECT * FROM admin WHERE email_admin = '$email' AND sandi_admin = '$password'";
$result = mysqli_query($conn, $query_sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION["username"] = $row["nama_admin"];
    header("Location: beranda.php");
    exit();
} else {
    echo "<center><h1>Email atau Password Anda Salah. Silahkan Coba Login Kembali.</h1>
          <button><strong><a href='loginAdmin.html'>Login</a></strong></button></center>";
}
?>
