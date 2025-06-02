<?php
$host = 'localhost';
$db = 'veritabani_adi';  // <-- Değiştirin
$user = 'kullanici_adi'; // <-- Değiştirin
$pass = 'sifre';         // <-- Değiştirin

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantısı başarısız: " . $e->getMessage());
}
?>
