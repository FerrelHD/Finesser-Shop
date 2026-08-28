<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produk->title ?? 'Detail Produk' }} - Finesser Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        .product-detail-page {
            margin-top: 90px;
            margin-bottom: 60px;
        }
        
        .breadcrumb-item a {
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s;
        }
        .breadcrumb-item a:hover {
            color: #0f172a;
        }
        .breadcrumb-item.active {
            color: #0f172a;
            font-weight: 600;
        }

        .gallery-main {
            position: relative;
            width: 100%;
            height: 440px;
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            border: 1px solid #f1f5f9;
        }

        .gallery-slide {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }

        .gallery-slide.active {
            opacity: 1;
            visibility: visible;
            position: relative;
        }

        .gallery-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .gallery-slide video {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #000;
        }

        .gallery-thumbnails {
            display: flex;
            gap: 12px;
            margin-top: 16px;
            overflow-x: auto;
            padding-bottom: 6px;
        }

        .thumb-btn {
            width: 80px;
            height: 65px;
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid transparent;
            cursor: pointer;
            padding: 0;
            background: #fff;
            transition: all 0.2s ease;
            flex-shrink: 0;
            opacity: 0.6;
        }

        .thumb-btn:hover {
            opacity: 0.9;
        }

        .thumb-btn.active {
            border-color: #0f172a;
            opacity: 1;
            transform: scale(1.04);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        .thumb-btn img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumb-video-icon {
            width: 100%;
            height: 100%;
            background: #1e293b;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .gallery-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            cursor: pointer;
            z-index: 5;
            transition: all 0.2s ease;
            color: #0f172a;
        }

        .gallery-arrow:hover {
            background: #fff;
            transform: translateY(-50%) scale(1.08);
        }

        .gallery-prev { left: 14px; }
        .gallery-next { right: 14px; }

        .product-meta-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            border: 1px solid #f1f5f9;
        }

        .product-badge-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 14px;
        }

        .product-price-tag {
            font-size: 2.2rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 20px;
        }

        .btn-buy-action {
            background: #0f172a;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px 28px;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.15);
        }

        .btn-buy-action:hover {
            background: #1e293b;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.25);
        }

        .benefit-list {
            list-style: none;
            padding: 0;
            margin: 24px 0 0 0;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.92rem;
            color: #475569;
            margin-bottom: 10px;
        }

        .benefit-item i {
            color: #10b981;
        }

        .layer-badge {
            display: inline-block;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #334155;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            margin: 0 6px 6px 0;
        }

        .tag-pill {
            display: inline-block;
            background: #f1f5f9;
            color: #64748b;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            margin: 0 4px 6px 0;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .gallery-main {
                height: 300px;
            }
            .product-meta-card {
                padding: 24px 18px;
            }
            .product-price-tag {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    @include('partials.layout.navbar')

    <main class="container product-detail-page">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($produk->title, 40) }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            <!-- Left: Gallery Section -->
            <div class="col-lg-7">
                <div class="gallery-main" id="productGallery">
                    @php
                        $slides = [];
                        if (!empty($produk->preview_image)) $slides[] = ['type' => 'image', 'url' => asset('storage/' . $produk->preview_image)];
                        if (!empty($produk->preview_image_2)) $slides[] = ['type' => 'image', 'url' => asset('storage/' . $produk->preview_image_2)];
                        if (!empty($produk->preview_image_3)) $slides[] = ['type' => 'image', 'url' => asset('storage/' . $produk->preview_image_3)];
                        if (!empty($produk->preview_video)) $slides[] = ['type' => 'video', 'url' => asset('storage/' . $produk->preview_video)];
                    @endphp

                    @forelse($slides as $index => $slide)
                        <div class="gallery-slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                            @if($slide['type'] === 'image')
                                <img src="{{ $slide['url'] }}" alt="{{ $produk->title }}" onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                            @else
                                <video controls>
                                    <source src="{{ $slide['url'] }}" type="video/mp4">
                                    Browser Anda tidak mendukung tag video.
                                </video>
                            @endif
                        </div>
                    @empty
                        <div class="gallery-slide active d-flex align-items-center justify-content-center bg-light">
                            <p class="text-muted"><i class="fas fa-image me-2"></i>Tidak ada pratinjau</p>
                        </div>
                    @endforelse

                    @if(count($slides) > 1)
                        <button type="button" class="gallery-arrow gallery-prev" id="galleryPrev" aria-label="Previous image">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" class="gallery-arrow gallery-next" id="galleryNext" aria-label="Next image">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    @endif
                </div>

                <!-- Thumbnails -->
                @if(count($slides) > 1)
                    <div class="gallery-thumbnails">
                        @foreach($slides as $index => $slide)
                            <button type="button" class="thumb-btn {{ $index === 0 ? 'active' : '' }}" data-target="{{ $index }}">
                                @if($slide['type'] === 'image')
                                    <img src="{{ $slide['url'] }}" alt="Thumbnail {{ $index + 1 }}">
                                @else
                                    <div class="thumb-video-icon">
                                        <i class="fas fa-play"></i>
                                    </div>
                                @endif
                            </button>
                        @endforeach
                    </div>
                @endif

                <!-- Detailed Description Section -->
                <div class="product-meta-card mt-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="fas fa-align-left me-2 text-primary"></i>Deskripsi Produk</h5>
                    <div class="text-secondary lh-lg mb-4">
                        {!! nl2br(e($produk->description)) !!}
                    </div>

                    @if(!empty($produk->editable_layers))
                        <h6 class="fw-bold text-dark mt-4 mb-2"><i class="fas fa-layer-group me-2 text-primary"></i>Editable Layers & Fitur:</h6>
                        <div class="mb-3">
                            @foreach($produk->editable_layers as $layer)
                                <span class="layer-badge"><i class="fas fa-check-circle me-1 text-success small"></i>{{ $layer }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if(!empty($produk->tags))
                        <div class="mt-4 pt-3 border-top">
                            <span class="text-muted small fw-semibold me-2">Tags:</span>
                            @foreach(explode(',', $produk->tags) as $tag)
                                <span class="tag-pill">#{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right: Action & Info Card -->
            <div class="col-lg-5">
                <div class="product-meta-card sticky-top" style="top: 100px; z-index: 10;">
                    <div class="product-badge-group">
                        @if(in_array(strtolower($produk->file_type), ['mp4', 'mov', 'avi']))
                            <span class="badge bg-primary px-3 py-2 rounded-pill"><i class="fas fa-video me-1"></i>Video Project</span>
                        @elseif(in_array(strtolower($produk->file_type), ['3d', 'obj', 'fbx', 'blend']))
                            <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fas fa-cube me-1"></i>3D Asset</span>
                        @elseif(strtolower($produk->file_type) === 'psd')
                            <span class="badge bg-info text-dark px-3 py-2 rounded-pill"><i class="fas fa-paint-brush me-1"></i>PSD Template</span>
                        @else
                            <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ strtoupper($produk->file_type) }}</span>
                        @endif

                        @if($produk->is_featured)
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="fas fa-star me-1"></i>Unggulan</span>
                        @endif

                        @if($produk->is_bundling)
                            <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="fas fa-boxes-stacked me-1"></i>Bundling Pack</span>
                        @endif
                    </div>

                    <h2 class="fw-bold text-dark mb-3">{{ $produk->title }}</h2>

                    <div class="product-price-tag">
                        @if($produk->price == 0)
                            <span class="text-success">Gratis</span>
                        @else
                            Rp {{ number_format($produk->price, 0, ',', '.') }}
                        @endif
                    </div>

                    <!-- Buy CTA -->
                    <a href="{{ route('checkout.show', $produk) }}" class="btn-buy-action mb-3">
                        <i class="fas fa-bolt"></i> Beli Sekarang
                    </a>

                    <!-- Benefits / Security Guarantee -->
                    <ul class="benefit-list">
                        <li class="benefit-item">
                            <i class="fas fa-bolt"></i>
                            <span>Akses download digital instan setelah pembayaran terverifikasi</span>
                        </li>
                        <li class="benefit-item">
                            <i class="fas fa-shield-halved"></i>
                            <span>File project asli, bersih, dan bebas virus</span>
                        </li>
                        <li class="benefit-item">
                            <i class="fas fa-certificate"></i>
                            <span>Lisensi: <strong>{{ ucfirst($produk->license_type ?? 'Personal') }} License</strong></span>
                        </li>
                        <li class="benefit-item">
                            <i class="fas fa-file-zipper"></i>
                            <span>Format File: <strong>.{{ strtoupper($produk->file_type) }}</strong></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    @include('partials.layout.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slides = document.querySelectorAll('.gallery-slide');
            const thumbs = document.querySelectorAll('.thumb-btn');
            const prevBtn = document.getElementById('galleryPrev');
            const nextBtn = document.getElementById('galleryNext');
            let current = 0;

            function goToSlide(index) {
                if (index < 0) index = slides.length - 1;
                if (index >= slides.length) index = 0;

                slides.forEach(s => s.classList.remove('active'));
                thumbs.forEach(t => t.classList.remove('active'));

                if (slides[index]) slides[index].classList.add('active');
                if (thumbs[index]) thumbs[index].classList.add('active');

                current = index;
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', () => goToSlide(current - 1));
            }
            if (nextBtn) {
                nextBtn.addEventListener('click', () => goToSlide(current + 1));
            }

            thumbs.forEach(thumb => {
                thumb.addEventListener('click', function () {
                    const target = parseInt(this.getAttribute('data-target'), 10);
                    goToSlide(target);
                });
            });
        });
    </script>
</body>
</html>
