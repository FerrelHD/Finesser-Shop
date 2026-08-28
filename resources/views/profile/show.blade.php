<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Saya - Finesser Shop</title>
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
                        <h2 class="mb-0 fw-bold">Profile Saya</h2>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </a>
                    </div>
                    
                    <div class="card-body">
                        <!-- Informasi Pribadi -->
                        <div class="mb-4">
                            <h3 class="fw-bold mb-3">Informasi Pribadi</h3>
                            <div class="bg-white rounded-3 shadow-sm p-4 border">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <h5 class="text-muted mb-2">Nama</h5>
                                        <p class="fs-5 fw-medium mb-0">{{ $user->name }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h5 class="text-muted mb-2">Email</h5>
                                        <p class="fs-5 fw-medium mb-0">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Riwayat Pemesanan -->
                        <div>
                            <h3 class="fw-bold mb-3">Riwayat Pemesanan</h3>
                            <div class="bg-white rounded-3 shadow-sm p-4 border">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="py-3">ID Pesanan</th>
                                                <th class="py-3">Produk</th>
                                                <th class="py-3">Total</th>
                                                <th class="py-3">Status</th>
                                                <th class="py-3 text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($orders as $order)
                                                <tr>
                                                    <td class="fw-medium">#{{ $order->id }}</td>
                                                    <td>{{ $order->product->title }}</td>
                                                    <td class="fw-medium">Rp {{ number_format($order->product->price, 0, ',', '.') }}</td>
                                                    <td>
                                                        <span class="badge {{ $order->status === 'verified' ? 'bg-success' : ($order->status === 'pending' ? 'bg-warning' : 'bg-danger') }} rounded-pill px-3">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('orders.show', $order->id) }}" 
                                                           class="btn btn-primary btn-sm rounded-pill px-3">
                                                            <i class="fas fa-eye me-1"></i>Detail
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">
                                                        Belum ada riwayat pemesanan
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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