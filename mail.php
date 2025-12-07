<?php
// PASTIKAN ANDA SUDAH MENGINSTAL PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// GANTI 'path/to/PHPMailer/...' dengan lokasi file PHPMailer Anda
require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Ambil dan bersihkan data dari formulir
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    // Cek apakah ada data yang kosong atau email tidak valid
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        header("Location: contact.php?success=0");
        exit;
    }

    // 2. Tentukan email penerima
    $recipient = "ddhykaa@gmail.com"; 
    $email_subject = "Pesan Kontak Baru dari Yayasan Dharma Laksana: " . $subject;

    // 3. Buat konten email
    $email_content = "Nama: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Pesan:\n$message\n";

    // 4. Kirim email menggunakan PHPMailer (Solusi SMTP)
    $mail = new PHPMailer(true); 

    try {
        // KONFIGURASI SMTP SERVER ANDA
        $mail->isSMTP(); 
        $mail->Host = 'mail.yayasan-dharma.com'; // **GANTI: Host SMTP Anda**
        $mail->SMTPAuth = true; 
        $mail->Username = 'no-reply@yayasan-dharma.com'; // **GANTI: Email yang digunakan untuk login SMTP**
        $mail->Password = 'SMTP-PASSWORD-ANDA'; // **GANTI: Password SMTP Anda**
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Atau PHPMailer::ENCRYPTION_STARTTLS
        $mail->Port = 465; // Biasanya 465 untuk SMTPS, 587 untuk STARTTLS

        // PENGIRIM DAN PENERIMA
        $mail->setFrom('no-reply@yayasan-dharma.com', 'Yayasan Dharma Laksana'); 
        $mail->addAddress($recipient); 
        
        // PENTING: Tambahkan Reply-To agar Anda bisa membalas ke email pengirim formulir
        $mail->addReplyTo($email, $name); 

        // KONTEN EMAIL
        $mail->isHTML(false); // Menggunakan Plain Text
        $mail->Subject = $email_subject;
        $mail->Body = $email_content;

        $mail->send();

        // Pengiriman berhasil
        http_response_code(200);
        header("Location: contact.php?success=1");
        exit;

    } catch (Exception $e) {
        // Pengiriman gagal
        // Anda bisa log error untuk debugging: error_log("Mailer Error: {$mail->ErrorInfo}");
        http_response_code(500);
        header("Location: contact.php?success=0");
        exit;
    }
} else {
    // Akses langsung ke file mail.php (bukan melalui POST)
    http_response_code(403);
    echo "Akses terlarang.";
}
?>