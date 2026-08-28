<div class="shop-container">
  <div id="not-found-message" style="display: none; margin-top: 30px; font-size: 18px; color: #888;">
    Produk tidak ditemukan.
  </div>
  
  @forelse ($produks as $produk)
    <div class="product-card">
      <div class="product-image">
        <a href="{{ route('produk.show', $produk->id) }}">
          <img 
            src="{{ asset('storage/' . $produk->preview_image) }}" 
            alt="{{ $produk->title }}" 
            style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0; display: block;"
            onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}'; console.log('Gambar tidak ditemukan: {{ $produk->preview_image }}');">
          <div class="product-overlay">
            <span class="view-details">Lihat Detail</span>
          </div>
        </a>
      </div>
      <div class="product-info">
        <div class="product-title">{{ $produk->title }}</div>
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
    <p>Tidak ada produk tersedia.</p>
  @endforelse
</div>