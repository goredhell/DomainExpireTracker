<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "db.php";
include "get_domain_expiry.php"; // API ile tarihi çekeceğiz

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $domain = $_POST['domain'];
    $expiry = getDomainExpiry($domain);

    if ($expiry === null) {
        $hata = "Alan adı bitiş tarihi alınamadı. Alan adı doğru mu?";
    } else {
        $stmt = $pdo->prepare("INSERT INTO domains (user_id, domain_name, expiry_date) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $domain, $expiry]);
        header("Location: dashboard.php");
        exit;
    }
}
?>

<h2>Yeni Domain Ekle</h2>
<form method="POST">
    Domain Adı: <input type="text" name="domain" required placeholder="example.com"><br>
    <button type="submit">Kaydet</button>
</form>

<?php if (isset($hata)) echo "<p style='color:red;'>$hata</p>"; ?>
