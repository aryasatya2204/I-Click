const productCards = document.querySelectorAll('.product-card');

productCards.forEach(card => {
  card.addEventListener('mouseenter', () => {
    card.style.transition = 'all 0.3s ease';
    
    card.style.transform = 'translateY(-10px)'; // Mengangkat card ke atas
    card.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)'; // Menambah bayangan
    card.style.cursor = 'pointer'; // Mengubah cursor
    card.style.backgroundColor = '#f8f9fa'; // Mengubah warna background sedikit
  });

  card.addEventListener('mouseleave', () => {
    card.style.transform = 'translateY(0)';
    card.style.boxShadow = 'none';
    card.style.backgroundColor = '#ffffff';
  });
});