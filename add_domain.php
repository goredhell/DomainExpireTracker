<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $domain = $_POST['domain'];
    $expiry = $_POST['expiry'];

    $stmt = $pdo->prepare("INSERT INTO domains (user_id, domain_name, expiry_date) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $domain, $expiry]);

    header("Location: dashboard.php");
    exit;
}
?>

<h2>Yeni Domain Ekle</h2>
<form method="POST">
    Domain Adı: <input type="text" name="domain" required><br>
    Bitiş Tarihi: <input type="date" name="expiry" required><br>
    <button type="submit">Kaydet</button>
</form>
