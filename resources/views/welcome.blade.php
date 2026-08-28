<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finesser - Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    @include('partials.layout.navbar')
    @include('partials.components.carousel')
    
    <!-- Featured Products Section -->
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="section-title">Produk Unggulan</h2>
                <p class="section-subtitle">Temukan produk terbaik kami</p>
            </div>
        </div> 
        <div class="row">
            <div class="col-12">
                <div class="shop-container">
                    @forelse ($produks->where('is_featured', true)->take(6) as $produk)
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
                            <div class="product-info">
                                <div class="product-title">{{ $produk->title }}</div>
                                <div class="product-type">
                                    @if(strtolower($produk->file_type) == 'mp4' || strtolower($produk->file_type) == 'mov' || strtolower($produk->file_type) == 'avi')
                                        <span class="badge bg-primary">Video</span>
                                    @elseif(strtolower($produk->file_type) == 'obj' || strtolower($produk->file_type) == 'fbx' || strtolower($produk->file_type) == '3d')
                                        <span class="badge bg-success">3D</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $produk->file_type }}</span>
                                    @endif
                                    <span class="badge bg-warning">Unggulan</span>
                                </div>
                                <div class="product-price">
                                    @if($produk->price == 0)
                                        Gratis
                                    @else
                                        Rp {{ number_format($produk->price, 0, ',', '.') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 w-100" style="grid-column: 1 / -1;">
                            <div class="p-4 bg-white rounded-4 shadow-sm d-inline-block mx-auto text-center" style="max-width: 440px; width: 100%;">
                                <i class="fas fa-star fa-2x mb-2 text-warning opacity-75"></i>
                                <h6 class="fw-bold text-dark mb-1">Belum Ada Produk Unggulan</h6>
                                <p class="text-muted small mb-0">Produk unggulan akan segera hadir.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('shop') }}" class="btn btn-outline-dark px-4 py-2">Lihat Semua Produk</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bundling Products Section -->
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="section-title">Produk Bundling</h2>
                <p class="section-subtitle">Dapatkan penawaran spesial dengan harga terbaik</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="shop-container">
                    @forelse ($produks->where('is_bundling', true)->take(6) as $produk)
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
                            <div class="product-info">
                                <div class="product-title">{{ $produk->title }}</div>
                                <div class="product-type">
                                    @if(strtolower($produk->file_type) == 'mp4' || strtolower($produk->file_type) == 'mov' || strtolower($produk->file_type) == 'avi')
                                        <span class="badge bg-primary">Video</span>
                                    @elseif(strtolower($produk->file_type) == 'obj' || strtolower($produk->file_type) == 'fbx' || strtolower($produk->file_type) == '3d')
                                        <span class="badge bg-success">3D</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $produk->file_type }}</span>
                                    @endif
                                    <span class="badge bg-danger">Bundling</span>
                                </div>
                                <div class="product-price">
                                    @if($produk->price == 0)
                                        Gratis
                                    @else
                                        Rp {{ number_format($produk->price, 0, ',', '.') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 w-100" style="grid-column: 1 / -1;">
                            <div class="p-4 bg-white rounded-4 shadow-sm d-inline-block mx-auto text-center" style="max-width: 440px; width: 100%;">
                                <i class="fas fa-boxes-stacked fa-2x mb-2 text-danger opacity-75"></i>
                                <h6 class="fw-bold text-dark mb-1">Belum Ada Paket Bundling</h6>
                                <p class="text-muted small mb-0">Paket bundling diskon akan segera diperbarui.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    @include('partials.components.about')
    @include('partials.layout.footer')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>