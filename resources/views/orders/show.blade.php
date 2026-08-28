<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Finesser Shop</title>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
    
    <div class="container" style="margin-top: 120px; margin-bottom: 80px;">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h2 class="mb-0 fw-bold">Detail Pesanan #{{ $order->id }}</h2>
                        <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                    
                    <div class="card-body">
                        <!-- Informasi Produk -->
                        <div class="mb-4">
                            <h3 class="fw-bold mb-3">Informasi Produk</h3>
                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-white rounded-3 shadow-sm p-4 border">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 mb-3 mb-md-0">
                                                @if($order->product->preview_image)
                                                    <img src="{{ asset('storage/' . $order->product->preview_image) }}" 
                                                         alt="{{ $order->product->title }}" 
                                                         class="img-fluid rounded-3 shadow-sm"
                                                         style="width: 100%; height: 200px; object-fit: cover;"
                                                         onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';">
                                                @else
                                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center shadow-sm" 
                                                         style="width: 100%; height: 200px;">
                                                        <i class="fas fa-image text-muted fa-3x"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-8">
                                                <div class="ps-md-4">
                                                    <h4 class="fw-bold mb-3">{{ $order->product->title }}</h4>
                                                    <div class="d-flex align-items-center mb-3">
                                                        <span class="fs-5 fw-semibold text-primary">
                                                            Rp {{ number_format($order->product->price, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Pesanan -->
                        <div class="mb-4">
                            <h3 class="fw-bold mb-3">Status Pesanan</h3>
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge {{ $order->status === 'verified' ? 'bg-success' : ($order->status === 'pending' ? 'bg-warning' : 'bg-danger') }} rounded-pill px-3 py-2">
                                    {{ ucfirst($order->status) }}
                                </span>
                                
                                @if($order->status === 'verified')
                                <a href="{{ route('download.file', $order) }}" class="btn btn-primary">
                                    <i class="fas fa-download me-2"></i>Download File
                                </a>
                                @endif

                                @if($order->status === 'pending')
                                <button id="btnBatalkanPesanan" class="btn btn-danger">
                                    <i class="fas fa-times me-2"></i>Batalkan Pesanan
                                </button>
                                @endif
                            </div>
                        </div>

                        <!-- Informasi Pembayaran -->
                        <div class="informasi-pembayaran">
                            <h2>Informasi Pembayaran</h2>
                            <div class="payment-details">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Tanggal Pemesanan</p>
                                        <p class="value">{{ $order->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Total Pembayaran</p>
                                        <p class="value text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        
                            @if($order->status === 'pending')
                                <div class="mt-4 text-center">
                                    <a href="{{ route('payment.show', $order) }}" class="btn btn-primary btn-lg">
                                        Lanjutkan Pembayaran
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.layout.footer')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnBatalkan = document.getElementById('btnBatalkanPesanan');
            if (btnBatalkan) {
                btnBatalkan.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Batalkan Pesanan?',
                        text: "Apakah Anda yakin ingin membatalkan pesanan ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Batalkan!',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Buat form untuk mengirim request POST
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route("orders.cancel", $order->id) }}';
                            
                            // Tambahkan CSRF token
                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '{{ csrf_token() }}';
                            form.appendChild(csrfToken);
                            
                            // Tambahkan form ke body dan submit
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>