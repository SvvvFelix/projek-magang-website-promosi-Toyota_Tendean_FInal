<?php
include 'config.php';
$result = $conn->query("SELECT * FROM gazoo_background ORDER BY id DESC");

// Fungsi mapping deskripsi ke kategori tab
function mapCategory($desc) {
    $desc = strtolower($desc);

    // 🔹 SUV
    if (strpos($desc, 'fortuner') !== false) return 'suv'; // Fortuner GR
    if (strpos($desc, 'raize') !== false) return 'suv';    // Raize GR
    if (strpos($desc, 'rush') !== false) return 'suv';     // Rush

    // 🔹 MPV
    if (strpos($desc, 'veloz') !== false) return 'mpv';          // All New Veloz
    if (strpos($desc, 'voxy') !== false) return 'mpv';           // All New Voxy
    if (strpos($desc, 'innova') !== false) return 'mpv';         // Innova Reborn

    // 🔹 Hatchback
    if (strpos($desc, 'yaris') !== false) return 'hatchback';    // Yaris GR
    if (strpos($desc, 'agya') !== false) return 'hatchback';     // Agya GR

    // 🔹 Sedan
    if (strpos($desc, 'camry') !== false) return 'sedan';        // Hanya Camry

    // 🔹 Commercial
    if (strpos($desc, 'hilux') !== false) return 'commercial';   // Hilux Rangga

    // Default fallback
    return 'mpv';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gazoo Racing</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <div class="logo-img">
      <a href="index.php">
        <img src="images/toyotalgb.png" alt="Toyota LGB">
      </a>
    </div>
    <div class="navbar-right">
      <a href="gazoo.php">Gazoo Racing</a>
      <a href="model.php">Model</a>
      <a href="more.php">More</a>
    </div>
  </div>

  <main class="gazoo-content">
    <div class="car-ads">
      <?php while ($row = $result->fetch_assoc()): ?>
        <?php $tab = mapCategory($row['description']); ?>
        <a href="model.php?tab=<?= $tab ?>">
          <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['description']) ?>">
        </a>
      <?php endwhile; ?>
    </div>
  </main>
</body>
</html>
