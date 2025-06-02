<?php
session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}
include "db.php";

// Yeni kullanıcı ekle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $stmt = $pdo->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $is_admin]);
}

// Kullanıcı silme
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
}

$users = $pdo->query("SELECT * FROM users")->fetchAll();
?>

<h2>Kullanıcı Yönetimi</h2>
<a href="dashboard.php">Geri Dön</a>
<h3>Yeni Kullanıcı Ekle</h3>
<form method="POST">
    Kullanıcı Adı: <input type="text" name="username" required>
    Şifre: <input type="password" name="password" required>
    Admin mi? <input type="checkbox" name="is_admin">
    <button type="submit">Ekle</button>
</form>

<h3>Mevcut Kullanıcılar</h3>
<table border="1">
    <tr><th>ID</th><th>Kullanıcı Adı</th><th>Yetki</th><th>Sil</th></tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= $user['is_admin'] ? 'Admin' : 'Kullanıcı' ?></td>
        <td><a href="?delete=<?= $user['id'] ?>" onclick="return confirm('Silinsin mi?')">Sil</a></td>
    </tr>
    <?php endforeach; ?>
</table>
