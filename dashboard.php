<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include "db.php";

$stmt = $pdo->prepare("SELECT * FROM domains WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$domains = $stmt->fetchAll();
?>

<h2>Hoş geldiniz, <?= htmlspecialchars($_SESSION['username']) ?></h2>
<a href="add_domain.php">Yeni Domain Ekle</a> |
<a href="logout.php">Çıkış</a>
<?php if ($_SESSION['is_admin']): ?>
 | <a href="user_manage.php">Kullanıcı Yönetimi</a>
<?php endif; ?>

<h3>Domainleriniz</h3>
<table border="1">
    <tr>
        <th>Domain</th>
        <th>Bitiş Tarihi</th>
    </tr>
    <?php foreach ($domains as $domain): ?>
    <tr>
        <td><?= htmlspecialchars($domain['domain_name']) ?></td>
        <td><?= htmlspecialchars($domain['expiry_date']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
