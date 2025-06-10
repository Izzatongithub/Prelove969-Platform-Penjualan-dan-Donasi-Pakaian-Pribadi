<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - Prelove969</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Custom CSS Variables untuk Warna */
        :root {
            --primary-color: #ff6b9d;
            --secondary-color: #a8e6cf;
            --accent-color: #ffd93d;
            --light-pink: #ffe4e8;
            --light-green: #e8f5e8;
            --light-purple: #f0e8ff;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
        }

        /* Font Family */
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
        }

        /* Header Styling */
        .navbar {
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            background-color: white !important;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color) !important;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
        }

        .search-filter-section {
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            padding: 25px;
            border: 1px solid rgba(255, 107, 157, 0.1);
        }

        .filter-chip {
            background: linear-gradient(45deg, var(--primary-color), #ff8fab);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 8px 20px;
            margin: 5px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .filter-chip:hover, .filter-chip.active {
            background: linear-gradient(45deg, #ff8fab, var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 157, 0.4);
            color: white;
        }

        .form-control, .form-select {
            border-radius: 15px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 157, 0.25);
        }

        .input-group-text {
            background: var(--light-pink);
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 15px 0 0 15px;
            color: var(--primary-color);
        }

        .product-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            margin-bottom: 25px;
            position: relative;
            border: 1px solid rgba(255, 107, 157, 0.1);
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .product-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 20px 20px 0 0;
        }

        .condition-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            border-radius: 50px;
            padding: 6px 12px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .condition-new { 
            background: linear-gradient(45deg, var(--secondary-color), #7fcdcd); 
            color: white; 
        }
        .condition-like-new { 
            background: linear-gradient(45deg, var(--accent-color), #ffed4e); 
            color: var(--text-dark); 
        }
        .condition-good { 
            background: linear-gradient(45deg, #ff8fab, var(--primary-color)); 
            color: white; 
        }

        .price-tag {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .price-free {
            color: white;
            background: linear-gradient(45deg, var(--secondary-color), #7fcdcd);
            padding: 8px 15px;
            border-radius: 50px;
            font-weight: 600;
        }

        .price-sale {
            color: var(--primary-color);
            font-weight: 700;
        }

        .category-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            font-size: 0.9rem;
        }

        .category-pria { 
            background: linear-gradient(45deg, #007bff, #0056b3); 
            color: white; 
        }
        .category-wanita { 
            background: linear-gradient(45deg, var(--primary-color), #ff8fab); 
            color: white; 
        }
        .category-anak { 
            background: linear-gradient(45deg, var(--secondary-color), #7fcdcd); 
            color: white; 
        }

        .no-results {
            text-align: center;
            padding: 50px 20px;
            color: #6c757d;
        }

        .btn-action {
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-detail {
            background: linear-gradient(45deg, var(--primary-color), #ff8fab);
            color: white;
        }

        .btn-detail:hover {
            background: linear-gradient(45deg, #ff8fab, var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 157, 0.4);
            color: white;
        }

        .btn-take {
            background: linear-gradient(45deg, var(--secondary-color), #7fcdcd);
            color: white;
        }

        .btn-take:hover {
            background: linear-gradient(45deg, #7fcdcd, var(--secondary-color));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(168, 230, 207, 0.4);
            color: white;
        }

        .results-info {
            background: var(--light-pink);
            border-left: 4px solid var(--primary-color);
            padding: 15px 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 2rem;
        }

        .page-title i {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .search-filter-section {
                padding: 15px;
            }
            
            .filter-chip {
                font-size: 0.8rem;
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-tshirt me-2"></i>Prelove969
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Katalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Jual/Donasi</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-user me-1"></i>Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-sign-out-alt me-1"></i>Keluar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="page-title"><i class="fas fa-store me-2"></i>Katalog Pakaian Prelove</h1>

        <!-- Search and Filter Section -->
        <div class="search-filter-section">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari nama item atau deskripsi...">
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <select class="form-select" id="locationFilter">
                        <option value="">Semua Lokasi</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Yogyakarta">Yogyakarta</option>
                        <option value="Semarang">Semarang</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <select class="form-select" id="sizeFilter">
                        <option value="">Semua Ukuran</option>
                        <option value="XS">XS</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL</option>
                    </select>
                </div>
            </div>

            <!-- Filter Chips -->
            <div class="row">
                <div class="col-12">
                    <h6 class="filter-section-title">Filter Kategori:</h6>
                    <button class="btn filter-chip active" data-filter="all">Semua</button>
                    <button class="btn filter-chip" data-filter="pria">Pria</button>
                    <button class="btn filter-chip" data-filter="wanita">Wanita</button>
                    <button class="btn filter-chip" data-filter="anak">Anak-anak</button>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                    <h6 class="filter-section-title">Filter Status:</h6>
                    <button class="btn filter-chip active" data-status="all">Semua</button>
                    <button class="btn filter-chip" data-status="jual">Dijual</button>
                    <button class="btn filter-chip" data-status="donasi">Donasi</button>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                    <h6 class="filter-section-title">Filter Kondisi:</h6>
                    <button class="btn filter-chip active" data-condition="all">Semua</button>
                    <button class="btn filter-chip" data-condition="baru">Baru</button>
                    <button class="btn filter-chip" data-condition="seperti-baru">Seperti Baru</button>
                    <button class="btn filter-chip" data-condition="lumayan">Lumayan</button>
                </div>
            </div>
        </div>

        <!-- Results Info -->
        <div class="results-info">
            <i class="fas fa-info-circle me-2"></i>
            Menampilkan <span id="resultCount">12</span> dari <span id="totalCount">12</span> produk
        </div>

        <!-- Product Grid -->
        <div class="row" id="productGrid">
            <!-- Products will be dynamically loaded here -->
        </div>

        <!-- No Results Message -->
        <div class="no-results" id="noResults" style="display: none;">
            <i class="fas fa-search fa-3x mb-3"></i>
            <h4>Tidak ada produk ditemukan</h4>
            <p>Coba ubah kata kunci pencarian atau filter yang Anda gunakan</p>
        </div>

        <!-- Pagination -->
        <nav aria-label="Product pagination" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Sebelumnya</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Selanjutnya</a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sample product data
        const products = [
            {
                id: 1,
                name: "Kemeja Formal Biru",
                category: "pria",
                condition: "seperti-baru",
                location: "Jakarta",
                price: 75000,
                status: "jual",
                size: "L",
                image: "https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=300&h=250&fit=crop",
                description: "Kemeja formal berkualitas tinggi"
            },
            {
                id: 2,
                name: "Dress Casual Pink",
                category: "wanita",
                condition: "baru",
                location: "Bandung",
                price: 0,
                status: "donasi",
                size: "M",
                image: "https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=300&h=250&fit=crop",
                description: "Dress cantik untuk acara casual"
            },
            {
                id: 3,
                name: "Kaos Anak Lucu",
                category: "anak",
                condition: "lumayan",
                location: "Surabaya",
                price: 25000,
                status: "jual",
                size: "S",
                image: "https://images.unsplash.com/photo-1503919545889-aef636e10ad4?w=300&h=250&fit=crop",
                description: "Kaos anak dengan gambar kartun"
            },
            {
                id: 4,
                name: "Jaket Denim Vintage",
                category: "pria",
                condition: "lumayan",
                location: "Yogyakarta",
                price: 0,
                status: "donasi",
                size: "XL",
                image: "https://images.unsplash.com/photo-1551028719-00167b16eac5?w=300&h=250&fit=crop",
                description: "Jaket denim klasik vintage"
            },
            {
                id: 5,
                name: "Blouse Putih Elegan",
                category: "wanita",
                condition: "baru",
                location: "Jakarta",
                price: 85000,
                status: "jual",
                size: "S",
                image: "https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=300&h=250&fit=crop",
                description: "Blouse putih untuk kerja"
            },
            {
                id: 6,
                name: "Celana Jeans Anak",
                category: "anak",
                condition: "seperti-baru",
                location: "Semarang",
                price: 35000,
                status: "jual",
                size: "M",
                image: "https://images.unsplash.com/photo-1519238263530-99bdd11df2ea?w=300&h=250&fit=crop",
                description: "Celana jeans anak kualitas bagus"
            },
            {
                id: 7,
                name: "Sweater Rajut Coklat",
                category: "wanita",
                condition: "seperti-baru",
                location: "Bandung",
                price: 0,
                status: "donasi",
                size: "L",
                image: "https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=300&h=250&fit=crop",
                description: "Sweater hangat untuk musim dingin"
            },
            {
                id: 8,
                name: "Kaos Polo Sport",
                category: "pria",
                condition: "baru",
                location: "Jakarta",
                price: 65000,
                status: "jual",
                size: "M",
                image: "https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=300&h=250&fit=crop",
                description: "Kaos polo untuk olahraga"
            },
            {
                id: 9,
                name: "Rok Mini Denim",
                category: "wanita",
                condition: "lumayan",
                location: "Surabaya",
                price: 40000,
                status: "jual",
                size: "S",
                image: "https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=300&h=250&fit=crop",
                description: "Rok denim untuk gaya casual"
            },
            {
                id: 10,
                name: "Jaket Anak Superhero",
                category: "anak",
                condition: "baru",
                location: "Yogyakarta",
                price: 0,
                status: "donasi",
                size: "L",
                image: "https://images.unsplash.com/photo-1519238263530-99bdd11df2ea?w=300&h=250&fit=crop",
                description: "Jaket dengan motif superhero"
            },
            {
                id: 11,
                name: "Kemeja Flanel Merah",
                category: "pria",
                condition: "seperti-baru",
                location: "Bandung",
                price: 50000,
                status: "jual",
                size: "L",
                image: "https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=300&h=250&fit=crop",
                description: "Kemeja flanel yang nyaman"
            },
            {
                id: 12,
                name: "Cardigan Rajut Abu",
                category: "wanita",
                condition: "lumayan",
                location: "Semarang",
                price: 55000,
                status: "jual",
                size: "M",
                image: "https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=300&h=250&fit=crop",
                description: "Cardigan hangat dan stylish"
            }
        ];

        let filteredProducts = [...products];

        // DOM Elements
        const productGrid = document.getElementById('productGrid');
        const searchInput = document.getElementById('searchInput');
        const locationFilter = document.getElementById('locationFilter');
        const sizeFilter = document.getElementById('sizeFilter');
        const resultCount = document.getElementById('resultCount');
        const totalCount = document.getElementById('totalCount');
        const noResults = document.getElementById('noResults');

        // Initialize
        totalCount.textContent = products.length;
        renderProducts(filteredProducts);

        // Search functionality
        searchInput.addEventListener('input', function() {
            applyFilters();
        });

        // Location filter
        locationFilter.addEventListener('change', function() {
            applyFilters();
        });

        // Size filter
        sizeFilter.addEventListener('change', function() {
            applyFilters();
        });

        // Filter chips
        document.querySelectorAll('.filter-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                const filterType = this.getAttribute('data-filter') || this.getAttribute('data-status') || this.getAttribute('data-condition');
                const filterGroup = this.parentElement.querySelector('h6').textContent;
                
                // Remove active class from siblings
                this.parentElement.querySelectorAll('.filter-chip').forEach(sibling => {
                    sibling.classList.remove('active');
                });
                
                // Add active class to clicked chip
                this.classList.add('active');
                
                applyFilters();
            });
        });

        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedLocation = locationFilter.value;
            const selectedSize = sizeFilter.value;
            const selectedCategory = document.querySelector('[data-filter].active')?.getAttribute('data-filter') || 'all';
            const selectedStatus = document.querySelector('[data-status].active')?.getAttribute('data-status') || 'all';
            const selectedCondition = document.querySelector('[data-condition].active')?.getAttribute('data-condition') || 'all';

            filteredProducts = products.filter(product => {
                const matchesSearch = product.name.toLowerCase().includes(searchTerm) || 
                                    product.description.toLowerCase().includes(searchTerm);
                const matchesLocation = !selectedLocation || product.location === selectedLocation;
                const matchesSize = !selectedSize || product.size === selectedSize;
                const matchesCategory = selectedCategory === 'all' || product.category === selectedCategory;
                const matchesStatus = selectedStatus === 'all' || product.status === selectedStatus;
                const matchesCondition = selectedCondition === 'all' || product.condition === selectedCondition;

                return matchesSearch && matchesLocation && matchesSize && 
                       matchesCategory && matchesStatus && matchesCondition;
            });

            resultCount.textContent = filteredProducts.length;
            
            if (filteredProducts.length === 0) {
                productGrid.style.display = 'none';
                noResults.style.display = 'block';
            } else {
                productGrid.style.display = 'flex';
                noResults.style.display = 'none';
                renderProducts(filteredProducts);
            }
        }

        function renderProducts(productsToRender) {
            productGrid.innerHTML = '';
            
            productsToRender.forEach(product => {
                const productCard = createProductCard(product);
                productGrid.appendChild(productCard);
            });
        }

        function createProductCard(product) {
            const col = document.createElement('div');
            col.className = 'col-lg-3 col-md-4 col-sm-6 mb-4';

            const conditionClass = {
                'baru': 'condition-new',
                'seperti-baru': 'condition-like-new',
                'lumayan': 'condition-good'
            };

            const categoryIcon = {
                'pria': 'fas fa-male',
                'wanita': 'fas fa-female',
                'anak': 'fas fa-child'
            };

            const categoryClass = {
                'pria': 'category-pria',
                'wanita': 'category-wanita',
                'anak': 'category-anak'
            };

            const priceDisplay = product.status === 'donasi' 
                ? '<span class="price-tag price-free">GRATIS</span>'
                : `<span class="price-tag price-sale">Rp ${product.price.toLocaleString('id-ID')}</span>`;

            const actionButton = product.status === 'donasi'
                ? '<button class="btn btn-take btn-action w-100">Ambil Sekarang</button>'
                : '<button class="btn btn-detail btn-action w-100">Lihat Detail</button>';

            col.innerHTML = `
                <div class="product-card" data-id="${product.id}">
                    <div class="position-relative">
                        <img src="${product.image}" alt="${product.name}" class="product-image">
                        <span class="condition-badge ${conditionClass[product.condition]}">
                            ${product.condition.charAt(0).toUpperCase() + product.condition.slice(1)}
                        </span>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center mb-2">
                            <span class="category-icon ${categoryClass[product.category]}">
                                <i class="${categoryIcon[product.category]}"></i>
                            </span>
                            <small class="text-muted">${product.category.charAt(0).toUpperCase() + product.category.slice(1)}</small>
                        </div>
                        <h6 class="card-title mb-2">${product.name}</h6>
                        <p class="card-text text-muted small mb-2">${product.description}</p>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">
                                <i class="fas fa-map-marker-alt me-1"></i>${product.location}
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-tag me-1"></i>${product.size}
                            </small>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            ${priceDisplay}
                        </div>
                        <div class="mt-3">
                            ${actionButton}
                        </div>
                    </div>
                </div>
            `;

            return col;
        }

        // Add event listeners for product actions
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-detail')) {
                const productCard = e.target.closest('.product-card');
                const productId = productCard.getAttribute('data-id');
                alert(`Membuka detail produk ID: ${productId}`);
                // Redirect ke halaman detail produk
            }
            
            if (e.target.classList.contains('btn-take')) {
                const productCard = e.target.closest('.product-card');
                const productId = productCard.getAttribute('data-id');
                alert(`Mengambil produk donasi ID: ${productId}`);
                // Proses ambil produk donasi
            }
        });
    </script>
</body>
</html>