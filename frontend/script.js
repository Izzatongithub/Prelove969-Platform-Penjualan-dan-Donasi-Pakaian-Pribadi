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

//untuk form uplaod gambar
    document.querySelector('input[type="file"]').addEventListener('change', function(event) {
        var fileList = event.target.files;
        var previewContainer = document.createElement('div');
        
        for (var i = 0; i < fileList.length; i++) {
            var file = fileList[i];
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.style.width = '100px'; // Menampilkan thumbnail gambar
                imgElement.style.marginRight = '10px';
                previewContainer.appendChild(imgElement);
            };
            
            reader.readAsDataURL(file);
        }
        
        // Hapus preview sebelumnya jika ada
        var previewDiv = document.getElementById('imagePreview');
        if (previewDiv) {
            previewDiv.innerHTML = '';
        } else {
            previewDiv = document.createElement('div');
            previewDiv.id = 'imagePreview';
            document.body.appendChild(previewDiv);
        }
        
        previewDiv.appendChild(previewContainer);
    });

  // Menambahkan event listener untuk input file
    document.querySelector('input[type="file"]').addEventListener('change', function(event) {
        var fileList = event.target.files; // Mendapatkan file yang dipilih
        var fileNamesContainer = document.getElementById('fileNamesList'); // Tempat untuk menampilkan daftar nama file
        
        // Mengosongkan daftar file sebelumnya
        fileNamesContainer.innerHTML = '';

        // Membuat list baru untuk nama file
        var fileListElement = document.createElement('ul');
        
        // Looping untuk setiap file yang dipilih
        for (var i = 0; i < fileList.length; i++) {
            var fileName = fileList[i].name; // Mendapatkan nama file
            var listItem = document.createElement('li'); // Membuat elemen list item untuk setiap file
            listItem.textContent = fileName; // Menambahkan nama file ke dalam list item
            fileListElement.appendChild(listItem); // Menambahkan list item ke dalam list
        }

        // Menambahkan daftar nama file ke dalam container
        fileNamesContainer.appendChild(fileListElement);
    });

    //close modal
    document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("loginModal");
    const btn = document.getElementById("loginBtn");
    const span = document.querySelector(".close");

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});

//search
//menyaring daftar produk secara langsung saat pengguna mengetik
document.getElementById('search').addEventListener('input', function () {
    const keyword = this.value.toLowerCase();
    const products = document.querySelectorAll('.product');

    products.forEach(product => {
        const title = product.querySelector('h3').textContent.toLowerCase();
        const description = product.querySelector('p')?.textContent.toLowerCase() || '';

        if (title.includes(keyword) || description.includes(keyword)) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    searchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        const products = document.querySelectorAll('.product');

        products.forEach(product => {
            const title = product.querySelector('h3').textContent.toLowerCase();
            const description = product.querySelector('p')?.textContent.toLowerCase() || '';

            if (title.includes(keyword) || description.includes(keyword)) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    });
});


