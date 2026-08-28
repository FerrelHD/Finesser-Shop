<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembayaran - Finesser Shop</title>
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

        .status-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            text-align: center;
            margin-top: 2rem;
        }
        .status-icon {
            font-size: 48px;
            margin-bottom: 1rem;
        }
        .status-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .status-message {
            color: #6c757d;
            margin-bottom: 2rem;
        }
        .btn-action {
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 500;
        }
    </style>
</head>
<body>

@include('partials.layout.navbar')

<div class="content-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="status-card">
                    @if($order->status === 'pending_verification')
                        <i class="fas fa-clock status-icon text-warning"></i>
                        <h2 class="status-title">Menunggu Verifikasi</h2>
                        <p class="status-message">
                            Pembayaran Anda sedang dalam proses verifikasi. 
                            Mohon tunggu beberapa saat.
                        </p>
                        <div class="spinner-border text-warning" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    @elseif($order->status === 'verified')
                        <i class="fas fa-check-circle status-icon text-success"></i>
                        <h2 class="status-title">Pembayaran Berhasil</h2>
                        <p class="status-message">
                            Terima kasih! Pembayaran Anda telah diverifikasi.
                        </p>
                        <a href="{{ route('download.file', $order) }}" class="btn btn-success btn-action">
                            <i class="fas fa-download me-2"></i>Download File
                        </a>
                    @else
                        <i class="fas fa-times-circle status-icon text-danger"></i>
                        <h2 class="status-title">Pembayaran Gagal</h2>
                        <p class="status-message">
                            Maaf, pembayaran Anda tidak dapat diproses.
                            Silakan coba lagi dengan metode pembayaran yang berbeda.
                        </p>
                        <a href="{{ route('payment.show', $order) }}" class="btn btn-primary btn-action">
                            <i class="fas fa-redo me-2"></i>Coba Lagi
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.layout.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.iife.js"></script>
<script>
    Pusher.logToConsole = false;

    const echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ config("broadcasting.connections.pusher.key") }}',
        cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
        forceTLS: true
    });

    echo.channel('payment.{{ $order->id }}')
        .listen('.payment.verified', (e) => {
            console.log("🔄 Event diterima:", e);
            window.location.reload();
        });
</script>

</body>
</html>