<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian | Finesser</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        body, .search-bg {
            background: #f8f9fa !important;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .search-results-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 40px 28px 32px 28px;
            border: none;
            margin-top: 48px;
            margin-bottom: 48px;
        }
        .search-title {
            font-family: 'Poppins', Arial, sans-serif;
            font-weight: 700;
            color: #333;
            margin-bottom: 18px;
            text-align: center;
            font-size: 2.2rem;
        }
        .search-subtitle {
            text-align: center;
            color: #6c757d;
            font-size: 1.08rem;
            margin-bottom: 32px;
        }
        .search-products-container {
            background: none;
            box-shadow: none;
            padding: 0;
            margin: 0;
        }
        .shop-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 25px;
            margin-bottom: 0;
        }
        @media (max-width: 768px) {
            .search-results-card {
                padding: 24px 8px 18px 8px;
            }
            .shop-container {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                gap: 14px;
            }
        }
    </style>
</head>
<body>
    @include('partials.layout.navbar')
    <div class="search-bg" style="min-height: 100vh;">
        <div class="container">
            <div class="search-results-card mx-auto">
                <h2 class="search-title">Hasil Pencarian</h2>
                @if($query)
                    <div class="search-subtitle">Menampilkan hasil untuk: <b>"{{ $query }}"</b></div>
                @endif
                <div class="search-products-container">
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
                                    <div class="product-title" style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 8px; line-height: 1.4; height: 44px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; font-family: 'Poppins', Arial, sans-serif;">{{ $produk->title }}</div>
                                    <div class="product-type" style="margin-bottom: 10px; display: flex; flex-wrap: wrap; gap: 5px;">
                                        @if(strtolower($produk->file_type) == 'mp4' || strtolower($produk->file_type) == 'mov' || strtolower($produk->file_type) == 'avi')
                                            <span class="badge bg-primary" style="font-size: 11px; font-weight: 500; padding: 5px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Video</span>
                                        @elseif(strtolower($produk->file_type) == 'obj' || strtolower($produk->file_type) == 'fbx' || strtolower($produk->file_type) == '3d')
                                            <span class="badge bg-success" style="font-size: 11px; font-weight: 500; padding: 5px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">3D</span>
                                        @else
                                            <span class="badge bg-secondary" style="font-size: 11px; font-weight: 500; padding: 5px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">{{ $produk->file_type }}</span>
                                        @endif
                                    </div>
                                    <div class="product-price" style="font-size: 18px; font-weight: 700; color: #111; font-family: 'Poppins', Arial, sans-serif;">
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
                                <div class="mb-3 text-muted opacity-50">
                                    <i class="fas fa-search fa-3x"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1">Tidak Ada Hasil Ditemukan</h5>
                                <p class="text-muted small mb-3">Coba gunakan kata kunci lain seperti "3d", "anime", "donut", atau "vfx".</p>
                                <a href="{{ route('shop') }}" class="btn btn-outline-dark rounded-pill px-4 py-2 small">
                                    Lihat Semua Produk
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.layout.footer')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
