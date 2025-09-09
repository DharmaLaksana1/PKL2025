<?php
session_start();
require "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query_sql = "SELECT * FROM admin 
                  WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query_sql);

    if (mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION["username"] = $row["username"];
        header("Location: adminpage.php");
        exit();
    } else {
        $error = "Username atau Password Anda salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
</head>
<body>
    <h2 style="text-align:center;">Login Admin</h2>

    <?php if (!empty($error)) { ?>
        <p style="color:red; text-align:center;"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST" action="" style="text-align:center;">
        <input type="text" name="username" placeholder="Masukkan Username" required><br><br>
        <input type="password" name="password" placeholder="Masukkan Password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
