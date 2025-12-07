<?php
// Terapkan instruksi pengguna: Berikan jawabannya saja, jangan sama penjelasannya.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Ambil dan bersihkan data dari formulir
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    // Cek apakah ada data yang kosong atau email tidak valid
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Jika ada error validasi
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

    // 4. Buat header email
    $email_headers = "From: $name <$email>\r\n";
    $email_headers .= "Reply-To: $email\r\n";
    $email_headers .= "MIME-Version: 1.0\r\n";
    $email_headers .= "Content-Type: text/plain; charset=utf-8\r\n";

    // 5. Kirim email
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        // Pengiriman berhasil
        http_response_code(200);
        header("Location: contact.php?success=1");
        exit;
    } else {
        // Pengiriman gagal (misalnya karena masalah konfigurasi server)
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