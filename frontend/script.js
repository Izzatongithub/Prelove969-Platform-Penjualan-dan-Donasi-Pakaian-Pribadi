document.getElementById("search").addEventListener("input", function() {
    let filter = this.value.toLowerCase();
    let products = document.querySelectorAll(".product");

    products.forEach(product => {
        let name = product.querySelector("h3").innerText.toLowerCase();
        if (name.includes(filter)) {
            product.style.display = "block";
        } else {
            product.style.display = "none";
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    let loginBtn = document.getElementById("loginBtn");
    let loginModal = document.getElementById("loginModal");
    let closeBtn = document.querySelector(".close");

    if (!loginBtn || !loginModal || !closeBtn) {
        console.error("Elemen modal tidak ditemukan!");
        return;
    }

    // Saat tombol Login diklik, modal muncul
    loginBtn.addEventListener("click", function(event) {
        event.preventDefault();
        loginModal.classList.add("show");
    });

    // Saat tombol close (X) diklik, modal hilang
    closeBtn.addEventListener("click", function() {
        loginModal.classList.remove("show");
    });

    // Klik di luar modal untuk menutupnya
    window.addEventListener("click", function(event) {
        if (event.target === loginModal) {
            loginModal.classList.remove("show");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    let dropdown = document.querySelector(".dropdown");
    let dropdownMenu = document.querySelector(".dropdown-menu");

    dropdown.addEventListener("mouseenter", function () {
        dropdownMenu.style.display = "flex";
    });

    dropdown.addEventListener("mouseleave", function () {
        dropdownMenu.style.display = "none";
    });
});



