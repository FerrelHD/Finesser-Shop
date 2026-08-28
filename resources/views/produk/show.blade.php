<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produk->title ?? 'Detail Produk' }} - Finesser Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding-top: 80px;
        }
        .product-image-container {
            position: relative;
            width: 100%;
            height: 400px;
            min-height: 400px;
            overflow: hidden;
            margin-top: 30px;
        }
        .product-image {
            width: 100%;
            height: 100%;
            border-radius: 8px;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 0.5s ease;
            z-index: 1;
            display: none;
            object-fit: cover;
        }
        .product-image.active {
            opacity: 1;
            z-index: 2;
            position: relative;
            display: block;
        }
        .product-image.fade-in {
            animation: fadeIn 0.5s;
        }
        .product-image.fade-out {
            animation: fadeOut 0.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        .product-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            margin-top: 30px;
        }
        .product-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
        }
        .btn-buy-now {
            background-color: white;
            color: #4CAF50;
            border: 2px solid #4CAF50;
            border-radius: 4px;
            padding: 12px 24px;
            font-weight: 600;
            width: 100%;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }
        .btn-buy-now:hover {
            background-color: #f0f8f0;
        }
        .product-requirements {
            margin-top: 30px;
            padding: 15px 0;
            border-top: 1px solid #eee;
        }
        .product-requirements h5 {
            font-weight: 600;
            margin-bottom: 15px;
        }
        .nav-arrows {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .nav-arrows:hover {
            background: rgba(255, 255, 255, 0.9);
        }
        .nav-prev {
            left: 10px;
        }
        .nav-next {
            right: 10px;
        }
        .slider-indicators {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }
        .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #ddd;
            margin: 0 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .indicator.active {
            background-color: #666;
        }
        .tags {
            margin-top: 15px;
        }
        .tag {
            display: inline-block;
            background-color: #f8f9fa;
            border-radius: 4px;
            padding: 5px 10px;
            margin: 0 5px 5px 0;
            font-size: 0.85rem;
        }
        .license-badge {
            display: inline-block;
            background-color: #e9ecef;
            color: #495057;
            border-radius: 4px;
            padding: 6px 12px;
            margin-top: 15px;
            font-size: 0.9rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    @include('partials.layout.navbar')

    <div class="container my-5 pt-4">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="product-image-container">
                    @if(isset($produk->preview_image) && !empty($produk->preview_image))
                        <img 
                            src="{{ asset('storage/' . $produk->preview_image) }}" 
                            class="product-image active" 
                            alt="{{ $produk->title }}" 
                            onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}'"
                        >
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 400px">
                            <p class="text-muted">Tidak ada gambar</p>
                        </div>
                    @endif
                    
                    @if(isset($produk->preview_image_2) && !empty($produk->preview_image_2))
                        <img src="{{ asset('storage/' . $produk->preview_image_2) }}" class="product-image" style="display: none;" alt="{{ $produk->title }}" onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                    @endif
                    
                    @if(isset($produk->preview_image_3) && !empty($produk->preview_image_3))
                        <img src="{{ asset('storage/' . $produk->preview_image_3) }}" class="product-image" style="display: none;" alt="{{ $produk->title }}" onerror="this.src='{{ asset('images/placeholder.jpg') }}';">
                    @endif
                    
                    @if(isset($produk->preview_video) && !empty($produk->preview_video))
                        <div class="product-image" style="display: none;">
                            <video width="100%" height="100%" controls>
                                <source src="{{ asset('storage/' . $produk->preview_video) }}" type="video/mp4">
                                Browser Anda tidak mendukung tag video.
                            </video>
                        </div>
                    @endif
                    
                    <div class="nav-arrows nav-prev">
                        <i class="fas fa-chevron-left"></i>
                    </div>
                    <div class="nav-arrows nav-next">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="slider-indicators">
                    <div class="indicator active"></div>
                    @if(isset($produk->preview_image_2) && !empty($produk->preview_image_2))
                        <div class="indicator"></div>
                    @endif
                    @if(isset($produk->preview_image_3) && !empty($produk->preview_image_3))
                        <div class="indicator"></div>
                    @endif
                    @if(isset($produk->preview_video) && !empty($produk->preview_video))
                        <div class="indicator"></div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <h1 class="product-title">{{ $produk->title ?? 'Judul Produk' }}</h1>
                
                <div class="product-price">
                    @if($produk->price == 0)
                        Gratis
                    @else
                        Rp {{ number_format($produk->price, 0, ',', '.') }}
                    @endif
                </div>

                <a href="{{ route('checkout.show', $produk) }}" class="btn btn-buy-now">Beli Sekarang</a>

                @if(isset($produk->description) && !empty($produk->description))
                <div class="product-requirements">
                    <h5>Deskripsi</h5>
                    <div>{!! $produk->description !!}</div>
                </div>
                @endif
                
                <div class="product-requirements">
                    @if(isset($produk->editable_layers) && !empty($produk->editable_layers))
                    <p><strong>Editable Layers:</strong>
                        @foreach($produk->editable_layers as $layer)
                            <span class="tag">{{ $layer }}</span>
                        @endforeach
                    </p>
                    @endif
                    
                    @if(isset($produk->file_type) && !empty($produk->file_type))
                    <p><strong>Tipe File:</strong> {{ $produk->file_type }}</p>
                    @endif
                    
                    @if(isset($produk->license_type) && !empty($produk->license_type))
                    <div class="license-badge">
                        <i class="fas fa-certificate me-1"></i> {{ $produk->license_type ?? 'Personal' }} License
                    </div>
                    @endif
                </div>
                
                @if(isset($produk->tags) && !empty($produk->tags))
                <div class="tags">
                    <h5>Tags:</h5>
                    @foreach(explode(',', $produk->tags) as $tag)
                        <span class="tag">{{ trim($tag) }}</span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    @include('partials.layout.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.product-image');
            const indicators = document.querySelectorAll('.indicator');
            const prevBtn = document.querySelector('.nav-prev');
            const nextBtn = document.querySelector('.nav-next');
            let currentIndex = 0;
            let isAnimating = false;
            
            // Inisialisasi tampilan awal
            function initSlider() {
                if (images.length > 0) {
                    images.forEach((img, index) => {
                        if (index === 0) {
                            img.classList.add('active');
                            img.style.display = 'block';
                        } else {
                            img.classList.remove('active');
                            img.style.display = 'none';
                        }
                    });
                }
            }
            
            initSlider();
            
            // Fungsi untuk menampilkan gambar dengan index tertentu
            function showImage(newIndex) {
                if (isAnimating || newIndex === currentIndex) return;
                isAnimating = true;
            
                indicators.forEach(ind => ind.classList.remove('active'));
                if (indicators[newIndex]) {
                    indicators[newIndex].classList.add('active');
                }
            
                const currentImg = images[currentIndex];
                const nextImg = images[newIndex];
            
                if (nextImg) {
                    // Jangan langsung display block, biarkan animasi berjalan bersamaan
                    nextImg.style.display = 'block';
                    nextImg.classList.remove('active', 'fade-in', 'fade-out');
                    nextImg.classList.add('fade-in');
            
                    currentImg.classList.remove('fade-in');
                    currentImg.classList.add('fade-out');
            
                    // Tunggu animasi fade-out selesai, baru display none
                    setTimeout(() => {
                        currentImg.classList.remove('active', 'fade-out');
                        currentImg.style.display = 'none';
                        nextImg.classList.remove('fade-in');
                        nextImg.classList.add('active');
                        currentIndex = newIndex;
                        isAnimating = false;
                    }, 500); // Pastikan waktu sama dengan durasi animasi CSS
                } else {
                    isAnimating = false;
                }
            }
            
            // Event listener untuk tombol prev
            if (prevBtn) {
                prevBtn.addEventListener('click', function() {
                    let newIndex = currentIndex - 1;
                    if (newIndex < 0) newIndex = images.length - 1;
                    showImage(newIndex);
                });
            }
            
            // Event listener untuk tombol next
            if (nextBtn) {
                nextBtn.addEventListener('click', function() {
                    let newIndex = currentIndex + 1;
                    if (newIndex >= images.length) newIndex = 0;
                    showImage(newIndex);
                });
            }
            
            // Event listener untuk indikator
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', function() {
                    showImage(index);
                });
            });
            
            // Tambahkan dukungan swipe untuk mobile
            const imageContainer = document.querySelector('.product-image-container');
            let touchStartX = 0;
            let touchEndX = 0;
            
            if (imageContainer) {
                imageContainer.addEventListener('touchstart', function(e) {
                    touchStartX = e.changedTouches[0].screenX;
                }, false);
                
                imageContainer.addEventListener('touchend', function(e) {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                }, false);
                
                function handleSwipe() {
                    const minSwipeDistance = 50;
                    const swipeDistance = touchEndX - touchStartX;
                    
                    if (swipeDistance > minSwipeDistance) {
                        // Swipe kanan (prev)
                        let newIndex = currentIndex - 1;
                        if (newIndex < 0) newIndex = images.length - 1;
                        showImage(newIndex);
                    } else if (swipeDistance < -minSwipeDistance) {
                        // Swipe kiri (next)
                        let newIndex = currentIndex + 1;
                        if (newIndex >= images.length) newIndex = 0;
                        showImage(newIndex);
                    }
                }
            }
        });
    </script>
</body>
</html>
<style>
    @media (max-width: 768px) {
        .product-image-container {
            height: 300px;
            min-height: 300px;
        }
        
        .nav-arrows {
            width: 30px;
            height: 30px;
        }
        .product-image video {
    width: 100%;
    height: 100%;
    object-fit: contain;
    background: #000;
}
    }
</style>
