<?php
// create_admin.php

include "db.php"; // PDO bağlantısı

// ADMIN bilgilerini gir
$username = 'admin';
$password = 'admin'; // değiştirilebilir
$is_admin = 1;

// Eğer kullanıcı zaten varsa tekrar ekleme
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
if ($stmt->rowCount() > 0) {
    echo "Kullanıcı zaten var: $username";
    exit;
}

// Şifreyi güvenli şekilde hash'le
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Kullanıcıyı ekle
$stmt = $pdo->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, ?)");
$stmt->execute([$username, $hashedPassword, $is_admin]);

echo "Admin kullanıcı başarıyla oluşturuldu: $username";
?>
