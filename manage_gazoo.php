<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

// Tambah background
if (isset($_POST['add'])) {
    $description = $_POST['description'];

    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $fileName = basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . time() . "_" . $fileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $sql = "INSERT INTO gazoo_background (image, description) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $targetFile, $description);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: manage_gazoo.php"); exit();
}

// Hapus
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $res = $conn->query("SELECT image FROM gazoo_background WHERE id=$id");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        if (file_exists($row['image'])) unlink($row['image']);
    }
    $conn->query("DELETE FROM gazoo_background WHERE id=$id");
    header("Location: manage_gazoo.php"); exit();
}

// Ambil data
$result = $conn->query("SELECT * FROM gazoo_background ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Gazoo Background</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <nav>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="manage_cars.php">🚗 Kelola Mobil</a>
    <a href="logout.php">🚪 Logout</a>
  </nav>

  <div class="container">
    <h1>Kelola Gazoo Background 🏎️</h1>

    <h2>Tambah Background Baru</h2>
    <form method="POST" enctype="multipart/form-data">
      <input type="file" name="image" accept="image/*" required>
      <textarea name="description" placeholder="Deskripsi" required></textarea>
      <button type="submit" name="add" class="btn">Tambah</button>
    </form>

    <h2>Daftar Background</h2>
    <table>
      <tr>
        <th>ID</th><th>Gambar</th><th>Deskripsi</th><th>Aksi</th>
      </tr>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><img src="<?= $row['image'] ?>" width="200"></td>
        <td><?= htmlspecialchars($row['description']) ?></td>
        <td><a href="manage_gazoo.php?delete=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Yakin hapus?')">Hapus</a></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>
</html>
