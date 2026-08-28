<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="overlay"></div>
            <img src="{{ asset('img/img1.jpg') }}" class="d-block w-100" alt="Hero 1">
        </div>
        <div class="carousel-item">
            <div class="overlay"></div>
            <img src="{{ asset('img/img2.jpg') }}" class="d-block w-100" alt="Hero 2">
        </div>
        <div class="carousel-item">
            <div class="overlay"></div>
            <img src="{{ asset('img/img3.jpg') }}" class="d-block w-100" alt="Hero 3">
        </div>
    </div>

    <div class="hero-caption">
                <h2 class="fw-bold">Selamat Datang di Finesser Shop</h2>
                <p>Temukan asset editing terbaik dan produk digital pilihan.</p>
            </div>

    <!-- Navigasi -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>