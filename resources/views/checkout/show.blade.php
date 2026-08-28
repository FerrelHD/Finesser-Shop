<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finesser Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
            padding-top: 80px; /* Menambahkan padding untuk navbar fixed */
        }
        
        .content-wrapper {
            flex: 1 0 auto;
            padding: 20px 0;
            margin-top: 40px; /* Tambahan margin atas */
        }
        
        .navbar {
            height: 70px; /* Mengatur tinggi navbar yang tetap */
        }

        /* Memperbaiki style card untuk tampilan yang lebih baik */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            margin-bottom: 20px;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #f1f1f1;
            padding: 16px 20px;
        }

        .card-body {
            padding: 20px;
        }

        /* Memperbaiki style produk */
        .product-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 4px;
        }

        .product-description {
            font-size: 0.85rem;
            color: #636e72;
        }

        .price-text {
            font-size: 1.25rem;
            font-weight: 600;
            color: #0984e3;
        }

        .summary-item {
            font-size: 0.875rem;
            color: #636e72;
        }

        /* Style tombol yang lebih modern */
        .btn-primary {
            padding: 12px 20px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
            background-color: #0984e3;
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(9, 132, 227, 0.15);
            background-color: #0773c5;
        }

        footer {
            flex-shrink: 0;
            background-color: #2d3436;
            color: white;
            padding: 20px 0;
            margin-top: auto;
        }
    </style>
</head>
<body>
    @include('partials.layout.navbar')
    
    <div class="content-wrapper">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Konfirmasi Pembelian</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('checkout.store', $produk) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <h6 class="text-muted mb-3">Detail Produk</h6>
                                    <div class="d-flex align-items-center">
                                        @if($produk->preview_image)
                                            <img src="{{ asset('storage/' . $produk->preview_image) }}" 
                                                 alt="{{ $produk->title }}" 
                                                 class="product-image me-3">
                                        @endif
                                        <div>
                                            <h6 class="product-title">{{ $produk->title }}</h6>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <h6 class="text-muted mb-3">Total Pembayaran</h6>
                                    <div class="price-text">
                                        @if($produk->price == 0)
                                            Gratis
                                        @else
                                            Rp {{ number_format($produk->price, 0, ',', '.') }}
                                        @endif
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100">
                                    @if($produk->price == 0)
                                        <i class="fas fa-download me-2"></i>Download Sekarang
                                    @else
                                        <i class="fas fa-credit-card me-2"></i>Lanjutkan ke Pembayaran
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="summary-item">Harga Produk</span>
                                <span class="summary-item">Rp {{ number_format($produk->price, 0, ',', '.') }}</span>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between">
                                <span class="fw-medium">Total</span>
                                <div class="product-price">
                                    @if($produk->price == 0)
                                        Gratis
                                    @else
                                        Rp {{ number_format($produk->price, 0, ',', '.') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.layout.footer')
</body>
</html>