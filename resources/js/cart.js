function updateCartBadge(count) {
    document.getElementById('cart-badge').textContent = count;
}

function addToCart(produkId) {
    fetch(`/cart/add/${produkId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        updateCartBadge(data.cartCount);
        alert(data.message);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menambahkan ke keranjang');
    });
}