<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

// Tambah mobil
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $fileName = basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . time() . "_" . $fileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $sql = "INSERT INTO cars (name, category, price, image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $category, $price, $targetFile);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: manage_cars.php"); exit();
}

// Update mobil
if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $fileName = basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . time() . "_" . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $res = $conn->query("SELECT image FROM cars WHERE id=$id");
            if ($res && $res->num_rows > 0) {
                $old = $res->fetch_assoc();
                if (file_exists($old['image'])) unlink($old['image']);
            }
            $sql = "UPDATE cars SET name=?, category=?, price=?, image=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $name, $category, $price, $targetFile, $id);
            $stmt->execute();
            $stmt->close();
        }
    } else {
        $sql = "UPDATE cars SET name=?, category=?, price=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $category, $price, $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: manage_cars.php"); exit();
}

// Hapus mobil
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $res = $conn->query("SELECT image FROM cars WHERE id=$id");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        if (file_exists($row['image'])) unlink($row['image']);
    }
    $conn->query("DELETE FROM cars WHERE id=$id");
    header("Location: manage_cars.php"); exit();
}

// Ambil data
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $res = $conn->query("SELECT * FROM cars WHERE id=$id");
    if ($res && $res->num_rows > 0) {
        $editData = $res->fetch_assoc();
    }
}

$result = $conn->query("SELECT * FROM cars ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Mobil</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <nav>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="manage_gazoo.php">🏎️ Kelola Gazoo</a>
    <a href="logout.php">🚪 Logout</a>
  </nav>

  <div class="container">
    <h1>Kelola Mobil 🚗</h1>

    <!-- Form Tambah / Edit -->
    <h2><?= $editData ? "Edit Mobil" : "Tambah Mobil Baru" ?></h2>
    <form method="POST" enctype="multipart/form-data" class="<?= $editData ? 'edit-mode' : '' ?>">
      <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
      <input type="text" name="name" placeholder="Nama Mobil" value="<?= $editData['name'] ?? '' ?>" required>
      <input type="text" name="category" placeholder="Kategori (MPV, SUV, dll)" value="<?= $editData['category'] ?? '' ?>" required>
      <input type="text" name="price" placeholder="Harga" value="<?= $editData['price'] ?? '' ?>" required>
      <input type="file" name="image" accept="image/*">
      <?php if ($editData): ?>
        <p>Gambar lama:<br><img src="<?= $editData['image'] ?>" width="120"></p>
      <?php endif; ?>
      <button type="submit" name="<?= $editData ? 'update' : 'add' ?>" class="btn">
        <?= $editData ? "Update" : "Tambah" ?>
      </button>
    </form>

    <!-- Daftar Mobil -->
    <h2>Daftar Mobil</h2>
    <table>
      <tr>
        <th>ID</th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Gambar</th><th>Aksi</th>
      </tr>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['category']) ?></td>
        <td><?= htmlspecialchars($row['price']) ?></td>
        <td><img src="<?= $row['image'] ?>" width="120"></td>
        <td>
          <a href="manage_cars.php?edit=<?= $row['id'] ?>" class="btn">Edit</a>
          <a href="manage_cars.php?delete=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>
</html>
