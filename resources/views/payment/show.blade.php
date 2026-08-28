<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Finesser Shop</title>
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
            padding-top: 80px;
        }
        
        .content-wrapper {
            flex: 1 0 auto;
            padding: 20px 0;
            margin-top: 40px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #f1f1f1;
            padding: 16px 20px;
        }

        .card-body {
            padding: 20px;
        }

        .form-label {
            font-weight: 500;
            color: #2d3436;
            margin-bottom: 8px;
        }

        .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #0984e3;
            box-shadow: 0 0 0 0.2rem rgba(9, 132, 227, 0.1);
        }

        .btn-primary {
            background-color: #0984e3;
            border: none;
            padding: 12px 20px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #0773c5;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(9, 132, 227, 0.15);
        }

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
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('payment.process', $order) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="mb-4">
                                    <h6 class="text-muted mb-3">Metode Pembayaran</h6>
                                    
                                    <div class="payment-methods">
                                        <!-- Transfer Bank Option -->
                                        <div class="payment-method-item mb-3">
                                            <input class="form-check-input" type="radio" name="payment_method" id="transfer" value="transfer">
                                            <label class="payment-method-label" for="transfer">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-university me-3 text-primary"></i>
                                                    <div>
                                                        <h6 class="mb-1">Transfer Bank</h6>
                                                        <p class="mb-2 text-muted small">Transfer ke rekening bank kami</p>
                                                        <div class="bank-details bg-light p-3 rounded">
                                                            <div class="mb-2">
                                                                <strong>Bank BCA</strong><br>
                                                                <span>1234567890</span><br>
                                                                <span>a.n. Finesser Shop</span>
                                                            </div>
                                                            <div>
                                                                <strong>Bank Mandiri</strong><br>
                                                                <span>0987654321</span><br>
                                                                <span>a.n. Finesser Shop</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    
                                        <!-- E-Wallet Option -->
                                        <div class="payment-method-item">
                                            <input class="form-check-input" type="radio" name="payment_method" id="ewallet" value="ewallet">
                                            <label class="payment-method-label" for="ewallet">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-wallet me-3 text-success"></i>
                                                    <div>
                                                        <h6 class="mb-1">E-Wallet</h6>
                                                        <p class="mb-2 text-muted small">Pembayaran melalui e-wallet</p>
                                                        <div class="ewallet-details bg-light p-3 rounded">
                                                            <div class="mb-2">
                                                                <strong>DANA</strong><br>
                                                                <span>081321686115</span>
                                                            </div>
                                                            <div>
                                                                <strong>GoPay</strong><br>
                                                                <span>081321686115</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h6 class="text-muted mb-3">Upload Bukti Pembayaran</h6>
                                    <input type="file" class="form-control" name="payment_proof" accept="image/*" required>
                                    <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                                </div>

                                <div class="mb-4">
                                    <h6 class="text-muted mb-3">Total Pembayaran</h6>
                                    <div class="price-text">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                </div>

                                <style>
                                    // Tambahkan CSS untuk Loading State:
                                    .btn:disabled {
                                        cursor: not-allowed;
                                        opacity: 0.7;
                                    }
                                    
                                    .loading-state {
                                        display: none;
                                    }
                                    
                                    .btn:disabled .normal-state {
                                        display: none;
                                    }
                                    
                                    .btn:disabled .loading-state {
                                        display: inline-block;
                                    }
                                    .btn-loading {
                                        position: relative;
                                        pointer-events: none;
                                        opacity: 0.8;
                                    }
                                    .btn-loading:after {
                                        content: '';
                                        width: 1rem;
                                        height: 1rem;
                                        border: 2px solid #fff;
                                        border-radius: 50%;
                                        border-right-color: transparent;
                                        animation: spin 0.8s linear infinite;
                                        position: absolute;
                                        right: 1rem;
                                        top: 50%;
                                        transform: translateY(-50%);
                                    }
                                    @keyframes spin {
                                        to { transform: translateY(-50%) rotate(360deg); }
                                    }
                                </style>
                                <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                    Konfirmasi Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Detail Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                @if($order->product->preview_image)
                                    <img src="{{ asset('storage/' . $order->product->preview_image) }}" 
                                         alt="{{ $order->product->title }}" 
                                         class="product-image me-3">
                                @endif
                                <div>
                                    <h6 class="product-title">{{ $order->product->title }}</h6>
                                </div>
                            </div>
                            <div class="price-text text-end">
                                @if($order->total_price == 0)
                                    Gratis
                                @else
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.layout.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>

<style>
    .payment-method-item {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 15px;
        transition: all 0.3s ease;
    }

    .payment-method-item:hover {
        border-color: #0984e3;
        background-color: #f8f9fa;
    }

    .payment-method-label {
        display: block;
        cursor: pointer;
        margin-bottom: 0;
        padding-left: 25px;
        position: relative;
    }

    .payment-method-item .form-check-input {
        position: absolute;
        margin-top: 20px;
    }

    .payment-method-item.selected {
        border-color: #0984e3;
        background-color: #f8f9fa;
    }

    .bank-details, .ewallet-details {
        font-size: 0.9rem;
        margin-top: 10px;
        border-left: 3px solid #0984e3;
    }

    .ewallet-details {
        border-left-color: #00b894;
    }
</style>

<script>
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.payment-method-item').forEach(item => {
                item.classList.remove('selected');
            });
            this.closest('.payment-method-item').classList.add('selected');
        });
    });
</script>

<!-- Tambahkan script di bagian bawah file -->
<script>
document.getElementById('paymentForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const submitBtn = document.getElementById('submitBtn');
    
    // Cek apakah form sudah disubmit
    if (submitBtn.classList.contains('btn-loading')) {
        return false;
    }
    
    // Validasi file upload
    const fileInput = document.querySelector('input[type="file"]');
    if (!fileInput.files.length) {
        alert('Silakan upload bukti pembayaran terlebih dahulu');
        return false;
    }
    
    // Tambahkan class loading dan ubah text
    submitBtn.classList.add('btn-loading');
    submitBtn.innerHTML = 'Memproses...';

    try {
        // Submit form menggunakan fetch
        const formData = new FormData(this);
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        if (response.ok) {
            // Redirect ke halaman status
            window.location.href = "{{ route('payment.status', $order) }}";
        } else {
            throw new Error('Gagal memproses pembayaran');
        }
    } catch (error) {
        alert('Terjadi kesalahan: ' + error.message);
        submitBtn.classList.remove('btn-loading');
        submitBtn.innerHTML = 'Konfirmasi Pembayaran';
    }
});
</script>