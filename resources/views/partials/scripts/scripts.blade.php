<script>
    // Fungsi pencarian
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

    // Fungsi keranjang
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
        const existingItem = cart.find(item => item.id === id);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: id,
                name: name,
                price: price,
                image: image,
                quantity: 1
            });
        }
        
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartBadge();
        showCartNotification();
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

    // Initialize
    updateCartBadge();
</script>