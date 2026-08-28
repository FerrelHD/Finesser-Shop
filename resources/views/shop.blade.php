<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Finesser</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        .category-filter {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
            gap: 1rem;
        }
        .category-btn {
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .category-btn.active {
            background-color: #212529;
            color: white;
        }
        .shop-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
        }
        .product-type {
            margin-bottom: 0.5rem;
        }
        .shop-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 3rem;
        }
        @media (max-width: 768px) {
            .shop-container {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 20px;
            }
        }
        @media (max-width: 576px) {
            .shop-container {
                grid-template-columns: repeat(auto-fill, minmax(100%, 1fr));
                gap: 20px;
            }
        }
        .product-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            margin-bottom: 25px;
            overflow: hidden;
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    @include('partials.layout.navbar')
    
    <div class="container mt-5 pt-5">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="shop-title">Shop</h1>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-12">
                <div class="category-filter">
                    <a href="{{ route('shop') }}" class="category-btn {{ $activeCategory == 'all' ? 'active' : '' }}">Semua</a>
                    <a href="{{ route('shop', ['category' => 'video']) }}" class="category-btn {{ $activeCategory == 'video' ? 'active' : '' }}">Video</a>
                    <a href="{{ route('shop', ['category' => '3D']) }}" class="category-btn {{ $activeCategory == '3D' ? 'active' : '' }}">3D</a>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div id="not-found-message" style="display: none; margin-top: 30px; font-size: 18px; color: #888;">
                    Produk tidak ditemukan.
                </div>
                
                <div class="shop-container">
                    @forelse ($produks as $produk)
                        <div class="product-card" data-category="{{ strtolower($produk->file_type) }}">
                            <div class="product-image">
                                <a href="{{ route('produk.show', $produk->id) }}">
                                    <img 
                                        src="{{ asset('storage/' . $produk->preview_image) }}" 
                                        alt="{{ $produk->title }}" 
                                        style="width: 100%; height: 220px; object-fit: cover; border-radius: 12px 12px 0 0; display: block;"
                                        onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}'; console.log('Gambar tidak ditemukan: {{ $produk->preview_image }}');">
                                    <div class="product-overlay">
                                        <span class="view-details">Lihat Detail</span>
                                    </div>
                                </a>
                            </div>
                            <div class="product-info" style="padding: 16px; position: relative;">
                                <div class="product-title" style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 8px; line-height: 1.4; height: 44px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $produk->title }}</div>
                                <div class="product-type" style="margin-bottom: 10px; display: flex; flex-wrap: wrap; gap: 5px;">
                                    @if(strtolower($produk->file_type) == 'mp4' || strtolower($produk->file_type) == 'mov' || strtolower($produk->file_type) == 'avi')
                                        <span class="badge bg-primary" style="font-size: 11px; font-weight: 500; padding: 5px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Video</span>
                                    @elseif(strtolower($produk->file_type) == 'obj' || strtolower($produk->file_type) == 'fbx' || strtolower($produk->file_type) == '3d')
                                        <span class="badge bg-success" style="font-size: 11px; font-weight: 500; padding: 5px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">3D</span>
                                    @else
                                        <span class="badge bg-secondary" style="font-size: 11px; font-weight: 500; padding: 5px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">{{ $produk->file_type }}</span>
                                    @endif
                                </div>
                                <div class="product-price" style="font-size: 18px; font-weight: 700; color: #111;">
                                    @if($produk->price == 0)
                                        Gratis
                                    @else
                                        Rp {{ number_format($produk->price, 0, ',', '.') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 w-100" style="grid-column: 1 / -1;">
                            <div class="p-5 bg-white rounded-4 shadow-sm d-inline-block mx-auto text-center" style="max-width: 480px; width: 100%;">
                                <div class="mb-3">
                                    <i class="fas fa-layer-group fa-3x" style="color: #cbd5e1;"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-2">Belum Ada Produk</h5>
                                <p class="text-muted small mb-4">Tidak ada produk ditemukan untuk filter kategori yang Anda pilih.</p>
                                <a href="{{ route('shop') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-medium">
                                    <i class="fas fa-sync-alt me-2"></i>Reset & Tampilkan Semua
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    @include('partials.layout.footer')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tambahkan style untuk kategori
            const categoryButtons = document.querySelectorAll('.category-btn');
            categoryButtons.forEach(button => {
                if (!button.classList.contains('active')) {
                    button.classList.add('btn-outline-dark');
                }
            });
        });
    </script>
</body>
</html>