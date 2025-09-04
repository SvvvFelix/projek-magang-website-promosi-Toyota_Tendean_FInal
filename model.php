<?php
include 'config.php';

// Ambil semua data mobil
$result = $conn->query("SELECT * FROM cars ORDER BY category, id DESC");

// Simpan data mobil per kategori
$categories = [
    "MPV" => [],
    "SUV" => [],
    "Hatchback" => [],
    "Sedan" => [],
    "Commercial" => []
];

while ($row = $result->fetch_assoc()) {
    // Pastikan kategori valid (jaga-jaga kalau typo di DB)
    if (isset($categories[$row['category']])) {
        $categories[$row['category']][] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toyota Models</title>
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

  <!-- Tabs -->
  <div class="tabs">
    <button class="tab-btn" data-target="mpv">MPV</button>
    <button class="tab-btn" data-target="suv">SUV</button>
    <button class="tab-btn" data-target="hatchback">Hatchback</button>
    <button class="tab-btn" data-target="sedan">Sedan</button>
    <button class="tab-btn" data-target="commercial">Commercial</button>
  </div>
  
  <!-- Content -->
  <div class="car-container">

    <!-- MPV -->
    <div class="tab-content active" id="mpv">
      <?php foreach ($categories['MPV'] as $car): ?>
        <div class="car-card">
          <img src="<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['name']) ?>">
          <h3><?= htmlspecialchars($car['name']) ?></h3>
          <p>Starting From</p>
          <div class="price"><?= htmlspecialchars($car['price']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- SUV -->
    <div class="tab-content" id="suv">
      <?php foreach ($categories['SUV'] as $car): ?>
        <div class="car-card">
          <img src="<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['name']) ?>">
          <h3><?= htmlspecialchars($car['name']) ?></h3>
          <p>Starting From</p>
          <div class="price"><?= htmlspecialchars($car['price']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Hatchback -->
    <div class="tab-content" id="hatchback">
      <?php foreach ($categories['Hatchback'] as $car): ?>
        <div class="car-card">
          <img src="<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['name']) ?>">
          <h3><?= htmlspecialchars($car['name']) ?></h3>
          <p>Starting From</p>
          <div class="price"><?= htmlspecialchars($car['price']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Sedan -->
    <div class="tab-content" id="sedan">
      <?php foreach ($categories['Sedan'] as $car): ?>
        <div class="car-card">
          <img src="<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['name']) ?>">
          <h3><?= htmlspecialchars($car['name']) ?></h3>
          <p>Starting From</p>
          <div class="price"><?= htmlspecialchars($car['price']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Commercial -->
    <div class="tab-content" id="commercial">
      <?php foreach ($categories['Commercial'] as $car): ?>
        <div class="car-card">
          <img src="<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['name']) ?>">
          <h3><?= htmlspecialchars($car['name']) ?></h3>
          <p>Starting From</p>
          <div class="price"><?= htmlspecialchars($car['price']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>

  <!-- Script -->
  <script src="script.js"></script>

</body>
</html>
