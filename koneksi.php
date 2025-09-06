<?php
$servername = "localhost";
$database = "u336544492_ydl";
$username = "root";
$password = "Ydl2024@pass";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn){
    die("koneksi error : " . mysql_connect_error());
}else{
    echo "";
}
