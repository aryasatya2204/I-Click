// class CartManager {
//     constructor() {
//         this.cartKey = 'shopping-cart';
//         this.updateBadge();
//         this.initializeEventListeners();
//     }

//     getCart() {
//         const cart = localStorage.getItem(this.cartKey);
//         return cart ? JSON.parse(cart) : [];
//     }

//     updateBadge() {
//         const cart = this.getCart();
//         const totalItems = cart.reduce((total, item) => total + (parseInt(item.quantity) || 0), 0);
//         const badgeElement = document.getElementById('cart-count');
        
//         if (badgeElement) {
//             // Pastikan badge selalu terlihat
//             badgeElement.style.display = 'inline-block';
//             // Update teks dengan jumlah item
//             badgeElement.textContent = totalItems.toString();
            
//             // Tambahan style untuk memastikan badge terlihat
//             badgeElement.style.position = 'absolute';
//             badgeElement.style.top = '-1px';
//             badgeElement.style.right = '10px';
//             badgeElement.className = 'badge bg-danger'; // Pastikan class tetap ada
            
//             // Sembunyikan hanya jika benar-benar 0
//             if (totalItems === 0) {
//                 badgeElement.style.display = 'none';
//             }
//         }
//     }

//     addToCart(item) {
//         const cart = this.getCart();
//         const existingItem = cart.find(i => i.id === item.id);
        
//         if (existingItem) {
//             existingItem.quantity = parseInt(existingItem.quantity) + parseInt(item.quantity);
//         } else {
//             cart.push({
//                 ...item,
//                 quantity: parseInt(item.quantity)
//             });
//         }
        
//         localStorage.setItem(this.cartKey, JSON.stringify(cart));
//         this.updateBadge();
//         this.triggerCartUpdate();
//     }

//     removeFromCart(itemId) {
//         const cart = this.getCart();
//         const updatedCart = cart.filter(item => item.id !== itemId);
//         localStorage.setItem(this.cartKey, JSON.stringify(updatedCart));
//         this.updateBadge();
//         this.triggerCartUpdate();
//     }

//     updateCartItemQuantity(itemId, newQuantity) {
//         const cart = this.getCart();
//         const item = cart.find(i => i.id === itemId);
//         if (item) {
//             item.quantity = parseInt(newQuantity);
//             if (item.quantity <= 0) {
//                 this.removeFromCart(itemId);
//             } else {
//                 localStorage.setItem(this.cartKey, JSON.stringify(cart));
//                 this.updateBadge();
//                 this.triggerCartUpdate();
//             }
//         }
//     }

//     initializeEventListeners() {
//         // Listen untuk perubahan storage di tab/window lain
//         window.addEventListener('storage', (e) => {
//             if (e.key === this.cartKey) {
//                 this.updateBadge();
//             }
//         });

//         // Listen untuk custom events
//         window.addEventListener('cartUpdated', () => {
//             this.updateBadge();
//         });

//         // Inisialisasi badge saat halaman dimuat
//         document.addEventListener('DOMContentLoaded', () => {
//             this.updateBadge();
//         });
//     }

//     triggerCartUpdate() {
//         window.dispatchEvent(new CustomEvent('cartUpdated'));
//     }

//     // Method untuk debug
//     logCartState() {
//         console.log('Current Cart State:', this.getCart());
//         const badgeElement = document.getElementById('cart-count');
//         console.log('Badge Element:', badgeElement);
//         console.log('Badge Display:', badgeElement?.style.display);
//         console.log('Badge Text:', badgeElement?.textContent);
//     }
// }

// // Initialize cart manager
// const cartManager = new CartManager();

// // Expose to window for global access
// window.cartManager = cartManager;