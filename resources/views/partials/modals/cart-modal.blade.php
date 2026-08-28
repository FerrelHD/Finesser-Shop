<!-- Modal Keranjang -->
<div class="modal fade" id="cartModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Keranjang Belanja</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="cartItems">
        <!-- Item keranjang akan ditampilkan di sini -->
      </div>
      <div class="modal-footer">
        <div class="total-section">
          Total: <span id="cartTotal">Rp 0</span>
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onclick="checkout()">Checkout</button>
      </div>
    </div>
  </div>
</div>