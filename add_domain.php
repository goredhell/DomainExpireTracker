<?php
// add_domain.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "db.php";

$hata = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $domain = trim($_POST['domain_name']);
    $expiry = $_POST['expiry_date'];

    if (empty($domain) || empty($expiry)) {
        $hata = "Alan adı ve bitiş tarihi zorunludur.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO domains (user_id, domain_name, expiry_date) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $domain, $expiry]);
        header("Location: dashboard.php");
        exit;
    }
}
?>

<h2>Yeni Alan Adı Ekle</h2>

<form method="POST">
    <label>Alan Adı:</label><br>
    <input type="text" name="domain_name" placeholder="ornek.com" required><br><br>

    <label>Bitiş Tarihi:</label><br>
    <input type="date" name="expiry_date" required><br><br>

    <button type="submit">Kaydet</button>
</form>

<?php if ($hata): ?>
    <p style="color: red;"><?= htmlspecialchars($hata) ?></p>
<?php endif; ?>
