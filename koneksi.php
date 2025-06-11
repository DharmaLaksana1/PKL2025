<?php
$servername = "localhost";
$database = "ydl";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn){
    die("koneksi error : " . mysql_connect_error());
}else{
    echo "";
}