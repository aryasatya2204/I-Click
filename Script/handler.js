document.addEventListener('DOMContentLoaded', function() {
  // Get all product cards
  const productCards = document.querySelectorAll('.product-card');
  
  // Add click event listener to each card
  productCards.forEach(card => {
    card.addEventListener('click', function() {
      // Get product details from the card

      let productDescription;
      const hiddenDesc = this.querySelector('#hidden-description');
      const hiddenDescClass = this.querySelector('.hidden-description');
      
      // Check which element exists and get its content
      if (hiddenDesc) {
          productDescription = hiddenDesc.textContent;
      } else if (hiddenDescClass) {
          productDescription = hiddenDescClass.textContent;
      } else {
          productDescription = 'Deskripsi tidak tersedia';
      }

      // Get product details and store them in an object
      const product = {
        image: this.querySelector('.product-image').src,
        title: this.querySelector('.product-title').textContent,
        price: this.querySelector('.product-price').textContent,
        rating: this.querySelector('.product-rating').textContent.replace('★', '').trim(),
        sold: this.querySelector('.product-sold').textContent.replace('Terjual', '').trim(),
        location: this.querySelector('.product-location').textContent,
        description: productDescription // Store the hidden description
      };
      
      // Store product details in sessionStorage
      sessionStorage.setItem('selectedProduct', JSON.stringify(product));
      
      // Navigate to product detail page
      window.location.href = 'product-detail.html';
    });
  });
});
