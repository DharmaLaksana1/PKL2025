<?php
session_start(); // Mulai sesi

require "koneksi.php";

$username = $_POST["username"];
$password = $_POST["password"];

$query_sql = "SELECT * FROM admin 
              WHERE username = '$username' AND password = '$password'";

$result = mysqli_query($conn, $query_sql);

if (mysqli_num_rows($result) > 0){
    // Jika login berhasil, simpan username dalam sesi
    $row = mysqli_fetch_assoc($result);
    $_SESSION["username"] = $row["username"]; // simpan username dari tabel
    header("Location: beranda.php");
    exit();
} else {
    echo "<center><h1>Username atau Password Anda Salah. Silahkan Coba Login Kembali.</h1>
            <button><strong><a href='loginAdmin.html'>Login</a></strong></button></center>";
}
?>
