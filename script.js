// Ambil semua tombol tab dan konten tab
const tabButtons = document.querySelectorAll(".tab-btn");
const tabContents = document.querySelectorAll(".tab-content");

// Loop setiap tombol tab
tabButtons.forEach(button => {
  button.addEventListener("click", () => {
    const target = button.getAttribute("data-target");

    // Hilangkan class 'active' dari semua tombol
    tabButtons.forEach(btn => btn.classList.remove("active"));

    // Tambahkan class 'active' ke tombol yang diklik
    button.classList.add("active");

    // Sembunyikan semua konten tab
    tabContents.forEach(content => content.classList.remove("active"));

    // Tampilkan tab yang sesuai dengan tombol
    document.getElementById(target).classList.add("active");
  });
});
