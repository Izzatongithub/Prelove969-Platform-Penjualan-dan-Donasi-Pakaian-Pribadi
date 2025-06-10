<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Item - Prelove969</title>
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

        /* Upload Form Styling */
        .upload-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 107, 157, 0.1);
        }

        .form-section {
            background: var(--light-pink);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            border-left: 4px solid var(--primary-color);
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .section-title i {
            color: var(--primary-color);
            margin-right: 10px;
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

        /* Image Upload Styling */
        .image-upload-area {
            border: 2px dashed var(--primary-color);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            background: rgba(255, 107, 157, 0.05);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .image-upload-area:hover {
            background: rgba(255, 107, 157, 0.1);
            transform: translateY(-2px);
        }

        .image-upload-area.dragover {
            background: rgba(255, 107, 157, 0.15);
            border-color: #ff8fab;
        }

        .upload-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .image-preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .image-preview {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            aspect-ratio: 1;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-remove {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.8rem;
        }

        /* Category and Condition Buttons */
        .option-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .option-btn {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .option-btn:hover {
            border-color: var(--primary-color);
            background: var(--light-pink);
        }

        .option-btn.active {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        /* Type Selection */
        .type-selection {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 15px;
        }

        .type-card {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .type-card:hover {
            border-color: var(--primary-color);
            background: var(--light-pink);
        }

        .type-card.active {
            border-color: var(--primary-color);
            background: var(--primary-color);
            color: white;
        }

        .type-card i {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        /* Price Input */
        .price-input-container {
            display: none;
            margin-top: 15px;
        }

        .price-input-container.show {
            display: block;
        }

        .input-group-text {
            background: var(--light-pink);
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 15px 0 0 15px;
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Submit Button */
        .btn-submit {
            background: linear-gradient(45deg, var(--primary-color), #ff8fab);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-submit:hover {
            background: linear-gradient(45deg, #ff8fab, var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 157, 0.4);
            color: white;
        }

        .btn-submit:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Alert Styling */
        .alert-custom {
            border-radius: 15px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: var(--light-green);
            color: #155724;
            border-left: 4px solid var(--secondary-color);
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
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

        /* Responsive */
        @media (max-width: 768px) {
            .upload-container {
                padding: 20px;
            }
            
            .form-section {
                padding: 20px;
            }
            
            .type-selection {
                grid-template-columns: 1fr;
            }
            
            .image-preview-container {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
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
                        <a class="nav-link" href="#">Katalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Jual/Donasi</a>
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
        <h1 class="page-title"><i class="fas fa-upload me-2"></i>Unggah Item Pakaian</h1>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Upload Form -->
        <div class="upload-container">
            <form id="uploadForm" enctype="multipart/form-data">
                <!-- Section 1: Upload Gambar -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-camera"></i>
                        Foto Pakaian
                    </h3>
                    <p class="text-muted mb-3">Upload maksimal 3 foto pakaian (JPG, PNG, max 2MB per file)</p>
                    
                    <div class="image-upload-area" onclick="document.getElementById('fileInput').click()">
                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                        <h5>Klik untuk Upload Gambar</h5>
                        <p class="text-muted">atau drag & drop gambar di sini</p>
                        <input type="file" id="fileInput" accept="image/*" multiple style="display: none;">
                    </div>
                    
                    <div class="image-preview-container" id="imagePreviewContainer"></div>
                </div>

                <!-- Section 2: Informasi Dasar -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Informasi Dasar
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="itemName" class="form-label fw-semibold">Nama Item *</label>
                            <input type="text" class="form-control" id="itemName" placeholder="Contoh: Kemeja Formal Biru" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label fw-semibold">Lokasi *</label>
                            <select class="form-select" id="location" required>
                                <option value="">Pilih Kota</option>
                                <option value="Jakarta">Jakarta</option>
                                <option value="Bandung">Bandung</option>
                                <option value="Surabaya">Surabaya</option>
                                <option value="Yogyakarta">Yogyakarta</option>
                                <option value="Semarang">Semarang</option>
                                <option value="Medan">Medan</option>
                                <option value="Makassar">Makassar</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Deskripsi *</label>
                        <textarea class="form-control" id="description" rows="3" placeholder="Deskripsikan kondisi dan detail pakaian..." required></textarea>
                    </div>
                </div>

                <!-- Section 3: Kategori dan Spesifikasi -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-tags"></i>
                        Kategori & Spesifikasi
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kategori *</label>
                            <div class="option-buttons">
                                <button type="button" class="option-btn" data-category="pria">
                                    <i class="fas fa-male me-2"></i>Pria
                                </button>
                                <button type="button" class="option-btn" data-category="wanita">
                                    <i class="fas fa-female me-2"></i>Wanita
                                </button>
                                <button type="button" class="option-btn" data-category="anak">
                                    <i class="fas fa-child me-2"></i>Anak-anak
                                </button>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="size" class="form-label fw-semibold">Ukuran *</label>
                            <select class="form-select" id="size" required>
                                <option value="">Pilih Ukuran</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                                <option value="All Size">All Size</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kondisi Pakaian *</label>
                        <div class="option-buttons">
                            <button type="button" class="option-btn" data-condition="baru">
                                <i class="fas fa-star me-2"></i>Baru
                            </button>
                            <button type="button" class="option-btn" data-condition="seperti-baru">
                                <i class="fas fa-star-half-alt me-2"></i>Seperti Baru
                            </button>
                            <button type="button" class="option-btn" data-condition="lumayan">
                                <i class="fas fa-star-half me-2"></i>Lumayan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Tipe dan Harga -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-handshake"></i>
                        Tipe Penawaran
                    </h3>
                    
                    <div class="type-selection">
                        <div class="type-card" data-type="jual">
                            <i class="fas fa-money-bill-wave"></i>
                            <h5>Dijual</h5>
                            <p class="text-muted">Jual pakaian dengan harga</p>
                        </div>
                        <div class="type-card" data-type="donasi">
                            <i class="fas fa-heart"></i>
                            <h5>Donasi</h5>
                            <p class="text-muted">Berikan gratis untuk yang membutuhkan</p>
                        </div>
                    </div>
                    
                    <div class="price-input-container" id="priceContainer">
                        <label for="price" class="form-label fw-semibold">Harga Jual *</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="price" placeholder="0" min="0">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-submit" id="submitBtn">
                        <i class="fas fa-upload me-2"></i>Unggah Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Global variables
        let selectedImages = [];
        let selectedCategory = '';
        let selectedCondition = '';
        let selectedType = '';

        // DOM Elements
        const fileInput = document.getElementById('fileInput');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const uploadArea = document.querySelector('.image-upload-area');
        const priceContainer = document.getElementById('priceContainer');
        const submitBtn = document.getElementById('submitBtn');
        const uploadForm = document.getElementById('uploadForm');
        const alertContainer = document.getElementById('alertContainer');

        // File upload handling
        fileInput.addEventListener('change', handleFileSelect);
        uploadArea.addEventListener('dragover', handleDragOver);
        uploadArea.addEventListener('drop', handleDrop);

        function handleFileSelect(e) {
            const files = Array.from(e.target.files);
            processFiles(files);
        }

        function handleDragOver(e) {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        }

        function handleDrop(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const files = Array.from(e.dataTransfer.files);
            processFiles(files);
        }

        function processFiles(files) {
            // Validate file count
            if (selectedImages.length + files.length > 3) {
                showAlert('error', 'Maksimal 3 gambar yang dapat diunggah!');
                return;
            }

            files.forEach(file => {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    showAlert('error', `File ${file.name} bukan gambar yang valid!`);
                    return;
                }

                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    showAlert('error', `File ${file.name} melebihi ukuran maksimal 2MB!`);
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageData = {
                        file: file,
                        url: e.target.result,
                        id: Date.now() + Math.random()
                    };
                    selectedImages.push(imageData);
                    renderImagePreview();
                };
                reader.readAsDataURL(file);
            });
        }

        function renderImagePreview() {
            imagePreviewContainer.innerHTML = '';
            selectedImages.forEach((image, index) => {
                const imageDiv = document.createElement('div');
                imageDiv.className = 'image-preview';
                imageDiv.innerHTML = `
                    <img src="${image.url}" alt="Preview ${index + 1}">
                    <button type="button" class="image-remove" onclick="removeImage(${image.id})">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                imagePreviewContainer.appendChild(imageDiv);
            });
        }

        function removeImage(imageId) {
            selectedImages = selectedImages.filter(img => img.id !== imageId);
            renderImagePreview();
        }

        // Category selection
        document.querySelectorAll('[data-category]').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from siblings
                this.parentElement.querySelectorAll('.option-btn').forEach(sibling => {
                    sibling.classList.remove('active');
                });
                
                // Add active class to clicked button
                this.classList.add('active');
                selectedCategory = this.getAttribute('data-category');
            });
        });

        // Condition selection
        document.querySelectorAll('[data-condition]').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from siblings
                this.parentElement.querySelectorAll('.option-btn').forEach(sibling => {
                    sibling.classList.remove('active');
                });
                
                // Add active class to clicked button
                this.classList.add('active');
                selectedCondition = this.getAttribute('data-condition');
            });
        });

        // Type selection
        document.querySelectorAll('[data-type]').forEach(card => {
            card.addEventListener('click', function() {
                // Remove active class from siblings
                this.parentElement.querySelectorAll('.type-card').forEach(sibling => {
                    sibling.classList.remove('active');
                });
                
                // Add active class to clicked card
                this.classList.add('active');
                selectedType = this.getAttribute('data-type');
                
                // Show/hide price input
                if (selectedType === 'jual') {
                    priceContainer.classList.add('show');
                    document.getElementById('price').required = true;
                } else {
                    priceContainer.classList.remove('show');
                    document.getElementById('price').required = false;
                }
            });
        });

        // Form submission
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate form
            if (!validateForm()) {
                return;
            }
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengunggah...';
            
            // Simulate form submission
            setTimeout(() => {
                // Create form data
                const formData = new FormData();
                
                // Add images
                selectedImages.forEach((image, index) => {
                    formData.append(`image_${index}`, image.file);
                });
                
                // Add form fields
                formData.append('name', document.getElementById('itemName').value);
                formData.append('description', document.getElementById('description').value);
                formData.append('category', selectedCategory);
                formData.append('size', document.getElementById('size').value);
                formData.append('condition', selectedCondition);
                formData.append('location', document.getElementById('location').value);
                formData.append('type', selectedType);
                
                if (selectedType === 'jual') {
                    formData.append('price', document.getElementById('price').value);
                }
                
                // Simulate successful upload
                console.log('Form data to be sent:', Object.fromEntries(formData));
                
                showAlert('success', 'Item berhasil diunggah! Akan segera ditampilkan di katalog.');
                resetForm();
                
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-upload me-2"></i>Unggah Sekarang';
                
            }, 2000);
        });

        function validateForm() {
            // Check if images are uploaded
            if (selectedImages.length === 0) {
                showAlert('error', 'Minimal 1 gambar harus diunggah!');
                return false;
            }
            
            // Check if category is selected
            if (!selectedCategory) {
                showAlert('error', 'Pilih kategori pakaian!');
                return false;
            }
            
            // Check if condition is selected
            if (!selectedCondition) {
                showAlert('error', 'Pilih kondisi pakaian!');
                return false;
            }
            
            // Check if type is selected
            if (!selectedType) {
                showAlert('error', 'Pilih tipe penawaran!');
                return false;
            }
            
            // Check required fields
            const requiredFields = ['itemName', 'description', 'size', 'location'];
            for (let field of requiredFields) {
                if (!document.getElementById(field).value.trim()) {
                    showAlert('error', 'Mohon lengkapi semua field yang wajib diisi!');
                    return false;
                }
            }
            
            // Check price if selling
            if (selectedType === 'jual') {
                const price = document.getElementById('price').value;
                if (!price || price <= 0) {
                    showAlert('error', 'Masukkan harga jual yang valid!');
                    return false;
                }
            }
            
            return true;
        }

        function showAlert(type, message) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
            
            const alertHtml = `
                <div class="alert ${alertClass} alert-custom alert-dismissible fade show" role="alert">
                    <i class="${icon} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            alertContainer.innerHTML = alertHtml;
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                const alert = alertContainer.querySelector('.alert');
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        }

        function resetForm() {
            // Reset form fields
            uploadForm.reset();
            
            // Reset images
            selectedImages = [];
            renderImagePreview();
            
            // Reset selections
            selectedCategory = '';
            selectedCondition = '';
            selectedType = '';
            
            // Remove active classes
            document.querySelectorAll('.option-btn.active').forEach(btn => {
                btn.classList.remove('active');
            });
            
            document.querySelectorAll('.type-card.active').forEach(card => {
                card.classList.remove('active');
            });
            
            // Hide price container
            priceContainer.classList.remove('show');
        }

        // Drag and drop visual feedback
        uploadArea.addEventListener('dragenter', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });
    </script>
</body>
</html>