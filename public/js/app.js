// Search functionality
const searchInput = document.getElementById('search-input');
const productCards = document.querySelectorAll('.product-card');

searchInput.addEventListener('input', () => {
    const query = searchInput.value.toLowerCase().trim();
    let hasResult = false;

    productCards.forEach(card => {
        const title = card.querySelector('.product-title').textContent.toLowerCase();
        if (title.includes(query)) {
            card.style.display = 'block';
            card.style.opacity = '1';
            hasResult = true;
        } else {
            card.style.display = 'none';
            card.style.opacity = '0';
        }
    });

    const notFoundMsg = document.getElementById('not-found-message');
    if (!hasResult && query !== "") {
        notFoundMsg.style.display = 'block';
    } else {
        notFoundMsg.style.display = 'none';
    }
});

// Cart functionality
let cart = JSON.parse(localStorage.getItem('cart')) || [];

function updateCartBadge() {
    const cartBadge = document.getElementById('cart-badge');
    if (cartBadge) {
        cartBadge.textContent = cart.reduce((total, item) => total + item.quantity, 0);
        cartBadge.style.display = cart.length > 0 ? 'block' : 'none';
    }
}

function showCart() {
    const modal = new bootstrap.Modal(document.getElementById('cartModal'));
    updateCartDisplay();
    modal.show();
}

function updateCartDisplay() {
    const cartItems = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');
    let total = 0;

    cartItems.innerHTML = cart.map(item => {
        total += item.price * item.quantity;
        return `
            <div class="cart-item">
                <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                <div class="cart-item-details">
                    <h6>${item.name}</h6>
                    <p>Rp ${item.price.toLocaleString('id-ID')}</p>
                    <div class="quantity-controls">
                        <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                    </div>
                </div>
            </div>
        `;
    }).join('');

    cartTotal.textContent = `Rp ${total.toLocaleString('id-ID')}`;
}

function addToCart(id, name, price, image) {
    console.log('Adding to cart:', id, name, price, image); // Debug info
    
    const existingItem = cart.find(item => item.id === id);
    
    if (existingItem) {
      existingItem.quantity += 1;
    } else {
      // Pastikan image memiliki nilai yang valid
      const imageUrl = image || '/images/placeholder.jpg'; // Pastikan path ini benar
      
      cart.push({
        id: id,
        name: name,
        price: price,
        image: imageUrl,
        quantity: 1
      });
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartBadge();
    showCartNotification();
}

function ensureImagesLoaded() {
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
      const img = card.querySelector('.product-image img');
      if (img) {
        // Coba muat ulang gambar jika belum dimuat
        if (!img.complete) {
          img.src = img.src;
        }
        
        // Tampilkan placeholder jika gambar gagal dimuat
        img.onerror = function() {
          this.onerror = null;
          this.src = '/images/placeholder.jpg'; // Pastikan path ini benar
          console.log('Menggunakan gambar placeholder untuk:', this.alt);
        };
      }
    });
}

function updateQuantity(id, newQuantity) {
    if (newQuantity <= 0) {
        cart = cart.filter(item => item.id !== id);
    } else {
        const item = cart.find(item => item.id === id);
        if (item) {
            item.quantity = newQuantity;
        }
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartBadge();
    updateCartDisplay();
}

// Initialize cart badge
updateCartBadge();

// Tambahkan kode ini di app.js
document.addEventListener('DOMContentLoaded', function() {
    const productImages = document.querySelectorAll('.product-image img');
    productImages.forEach(img => {
        img.addEventListener('error', function() {
            console.error('Gagal memuat gambar:', this.src);
        });
        img.addEventListener('load', function() {
            console.log('Gambar berhasil dimuat:', this.src);
        });
    });
});

  function ensureImagesLoaded() {
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
      const img = card.querySelector('.product-image img');
      if (img) {
        // Coba muat ulang gambar jika belum dimuat
        if (!img.complete) {
          img.src = img.src;
        }
        
        // Tampilkan placeholder jika gambar gagal dimuat
        img.onerror = function() {
          this.onerror = null;
          this.src = '/images/placeholder.jpg';
          console.log('Menggunakan gambar placeholder untuk:', this.alt);
        };
      }
    });
  }
  
  // Panggil fungsi setelah halaman dimuat
  window.addEventListener('load', ensureImagesLoaded);