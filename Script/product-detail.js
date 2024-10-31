// Fungsi untuk membersihkan dan memformat harga
function extractPrice(priceString) {
    return parseFloat(priceString.replace(/[^0-9,-]+/g, '').replace(',', '.'));
}

// Tunggu hingga halaman sepenuhnya dimuat
document.addEventListener('DOMContentLoaded', () => {
    // Ambil data produk dari sessionStorage
    const product = JSON.parse(sessionStorage.getItem('selectedProduct'));

    // Referensi ke elemen DOM
    const productImage = document.getElementById('product-image');
    const productTitle = document.getElementById('product-title');
    const productPrice = document.getElementById('product-price');
    const productOriginalPrice = document.getElementById('product-original-price');
    const productRating = document.getElementById('product-rating');
    const productSold = document.getElementById('product-sold');
    const productDescription = document.getElementById('product-description');
    const addToCartBtn = document.getElementById('add-to-cart');
    const cartLink = document.querySelector('.nav-link.me-3');
    const quantityDecreaseBtn = document.getElementById('quantity-decrease');
    const quantityIncreaseBtn = document.getElementById('quantity-increase');
    const quantityElement = document.getElementById('quantity');

    // Menampilkan data produk di halaman
    if (product) {
        productImage.src = product.image || '/api/placeholder/400/400';
        productTitle.textContent = product.title || 'Nama Produk';
        productPrice.textContent = product.price || 'Harga tidak tersedia';
        productOriginalPrice.textContent = product.originalPrice || '';
        productRating.textContent = product.rating || '0';
        productSold.textContent = product.sold || '0';
        productDescription.textContent = product.description || 'Deskripsi tidak tersedia';
    } else {
        console.warn('Tidak ada data produk yang tersedia');
    }

    // Mengelola jumlah produk
    let quantity = 1;
    quantityElement.textContent = quantity;

    quantityDecreaseBtn.addEventListener('click', () => {
        quantity = Math.max(1, quantity - 1);
        quantityElement.textContent = quantity;
    });

    quantityIncreaseBtn.addEventListener('click', () => {
        quantity += 1;
        quantityElement.textContent = quantity;
    });

    // Fungsi untuk memperbarui jumlah item di ikon keranjang
    function updateCartCount() {
        const cartCountElement = document.getElementById('cart-count');
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCountElement.textContent = totalItems;
    }


     // Fungsi untuk menampilkan notifikasi singkat di bawah ikon keranjang
     function showNotification() {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: absolute;
            top: 40px; 
            right: 0;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            z-index: 1000;
            transition: opacity 0.5s;
            white-space: nowrap;
        `;
        notification.textContent = 'Produk berhasil ditambahkan ke keranjang';
        
        // Menambahkan notifikasi sebagai elemen anak dari ikon keranjang
        cartIcon.parentNode.appendChild(notification);

        // Hilangkan setelah 2 detik
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                cartIcon.parentNode.removeChild(notification);
            }, 500);
        }, 2000);
    }

    // Tambahkan produk ke keranjang saat tombol diklik
    addToCartBtn.addEventListener('click', () => {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const productPrice = extractPrice(product.price);
        const cartItem = {
            ...product,
            price: productPrice,
            quantity: quantity
        };

        const existingProduct = cart.find(item => item.title === product.title);
        if (existingProduct) {
            existingProduct.quantity += quantity;
        } else {
            cart.push(cartItem);
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        showNotification();
    });

    // Update cart count saat halaman dimuat
    updateCartCount();
});
