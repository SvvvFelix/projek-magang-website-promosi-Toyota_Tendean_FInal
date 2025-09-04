<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <nav>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="manage_cars.php">🚗 Kelola Mobil</a>
        <a href="manage_gazoo.php">🏎️ Kelola Gazoo</a>
        <a href="logout.php">🚪 Logout</a>
    </nav>

    <div class="container">
        <h1>Selamat Datang, <?= htmlspecialchars($_SESSION['admin']); ?> 👋</h1>
        <p>Silakan pilih menu di atas untuk mengelola data.</p>
    </div>
</body>
</html>
