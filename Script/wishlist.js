// Fungsi untuk mengambil dan membersihkan harga dari elemen #product-price
function parsePrice(priceText) {
    // Menghapus "Rp" dan titik pemisah ribuan, kemudian mengonversi ke angka
    const cleanedPrice = priceText.replace(/[Rp\s.,]/g, '').trim();
    return parseInt(cleanedPrice, 10); // Mengonversi hasil ke dalam angka bulat
}

// Fungsi untuk menambahkan produk ke wishlist
function addToWishlist() {
    const product = {
        id: document.getElementById("product-detail").dataset.id,
        name: document.getElementById("product-title").textContent,
        price: parsePrice(document.getElementById("product-price").textContent), // Menggunakan parsePrice untuk mendapatkan harga sebagai angka
        image: document.getElementById("product-image").src
    };

    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

    if (!wishlist.some(item => item.id === product.id)) {
        wishlist.push(product);
        localStorage.setItem("wishlist", JSON.stringify(wishlist));
        alert("Produk ditambahkan ke wishlist!");
    } else {
        alert("Produk sudah ada di wishlist.");
    }
}

// Fungsi untuk memformat harga ke dalam format rupiah
function formatPrice(price) {
    return "Rp " + parseFloat(price).toLocaleString("id-ID", {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
}

// Fungsi untuk menampilkan produk di wishlist
function loadWishlist() {
    const wishlistContainer = document.getElementById("wishlist-container");
    const wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

    wishlistContainer.innerHTML = ""; // Kosongkan container sebelum menambahkan

    if (wishlist.length === 0) {
        wishlistContainer.innerHTML = "<p class='text-center'>Wishlist Anda kosong.</p>";
        return;
    }

    wishlist.forEach(product => {
        const productElement = document.createElement("div");
        productElement.classList.add("col-md-4", "mb-4");

        productElement.innerHTML = `
            <div class="card">
                <img src="${product.image}" class="card-img-top" alt="${product.name}">
                <div class="card-body">
                    <h5 class="card-title">${product.name}</h5>
                    <p class="card-text">${formatPrice(product.price)}</p>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary add-to-cart" data-id="${product.id}">Tambah ke Keranjang</button>
                        <button class="btn btn-danger remove-wishlist" data-id="${product.id}">Hapus</button>
                    </div>
                </div>
            </div>
        `;
        wishlistContainer.appendChild(productElement);
    });

    wishlistContainer.addEventListener("click", handleWishlistActions);
}

// Fungsi untuk menangani aksi di wishlist
function handleWishlistActions(event) {
    const productId = event.target.getAttribute("data-id");

    if (event.target.classList.contains("add-to-cart")) {
        addToCartFromWishlist(productId);
    } else if (event.target.classList.contains("remove-wishlist")) {
        removeFromWishlist(productId);
    }
}

// Fungsi untuk menambahkan produk dari wishlist ke keranjang
function addToCartFromWishlist(productId) {
    const wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
    const product = wishlist.find(item => item.id === productId);

    if (product) {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];

        const existingProduct = cart.find(item => item.id === product.id);
        if (existingProduct) {
            existingProduct.quantity += 1;
        } else {
            cart.push({ ...product, quantity: 1 });
        }

        localStorage.setItem("cart", JSON.stringify(cart));
        alert("Produk berhasil ditambahkan ke keranjang!");
    }
}

// Fungsi untuk menghapus produk dari wishlist
function removeFromWishlist(productId) {
    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
    wishlist = wishlist.filter(product => product.id !== productId);

    localStorage.setItem("wishlist", JSON.stringify(wishlist));
    loadWishlist();
}

// Memuat wishlist saat halaman dimuat
window.onload = loadWishlist;



