document.addEventListener('DOMContentLoaded', () => {
    const cartItemsContainer = document.getElementById('cart-items');
    const cartTotalPrice = document.getElementById('cart-total-price');

    // Fungsi untuk memperbarui tampilan total harga
    function updateTotalPrice(cart) {
        const totalPrice = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
        cartTotalPrice.textContent = `Rp ${totalPrice.toLocaleString()}`;
    }

    // Fungsi untuk menyimpan keranjang yang diperbarui ke localStorage
    function saveCart(cart) {
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    // Fungsi untuk memperbarui tampilan item keranjang
    function renderCartItems() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cartItemsContainer.innerHTML = ''; // Bersihkan konten lama
        

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            const itemElement = document.createElement('div');
            itemElement.classList.add('cart-item', 'd-flex', 'justify-content-between', 'align-items-center');

            itemElement.innerHTML = `
                <div class="d-flex align-items-center">
                    <img src="${item.image}" alt="${item.title}" class="me-3" style="max-width: 80px;"/>
                    <div>
                        <h5>${item.title}</h5>
                        <p>Harga: Rp ${item.price.toLocaleString()}</p>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-secondary btn-sm me-2 decrease-quantity" data-index="${index}">-</button>
                            <span>${item.quantity}</span>
                            <button class="btn btn-outline-secondary btn-sm ms-2 increase-quantity" data-index="${index}">+</button>
                        </div>
                    </div>
                </div>
                <div>
                    <p>Rp ${itemTotal.toLocaleString()}</p>
                    <button class="btn btn-danger btn-sm remove-item" data-index="${index}">Hapus</button>
                </div>
            `;

            cartItemsContainer.appendChild(itemElement);
        });

        // Perbarui total harga setelah render
        updateTotalPrice(cart);
    }

    // Event handler untuk menambah atau mengurangi quantity dan menghapus item
    cartItemsContainer.addEventListener('click', (event) => {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const index = event.target.getAttribute('data-index');

        if (event.target.classList.contains('increase-quantity')) {
            // Tambahkan quantity item
            cart[index].quantity += 1;
            saveCart(cart);
            renderCartItems();

        } else if (event.target.classList.contains('decrease-quantity')) {
            // Kurangi quantity item, jika lebih dari 1
            if (cart[index].quantity > 1) {
                cart[index].quantity -= 1;
            } else {
                // Jika quantity = 1, hapus item
                cart.splice(index, 1);
            }
            saveCart(cart);
            renderCartItems();

        } else if (event.target.classList.contains('remove-item')) {
            // Hapus item dari cart
            cart.splice(index, 1);
            saveCart(cart);
            renderCartItems();
        }
    });

    // Render ulang item di cart saat halaman dimuat
    renderCartItems();
});

