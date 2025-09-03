const tabButtons = document.querySelectorAll(".tab-btn");
const tabContents = document.querySelectorAll(".tab-content");

tabButtons.forEach(button => {
  button.addEventListener("click", () => {
    const target = button.getAttribute("data-target");

    // hapus semua 'active'
    tabButtons.forEach(btn => btn.classList.remove("active"));
    tabContents.forEach(content => content.classList.remove("active"));

    // tambahkan 'active' ke tombol yang diklik + konten target
    button.classList.add("active");
    document.getElementById(target).classList.add("active");
  });
});

// 🔹 Cek URL untuk parameter tab
const params = new URLSearchParams(window.location.search);
const activeTab = params.get("tab");

if (activeTab) {
  const targetButton = document.querySelector(`.tab-btn[data-target="${activeTab}"]`);
  if (targetButton) targetButton.click(); // otomatis klik tab yang sesuai
}
