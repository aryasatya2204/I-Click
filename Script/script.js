document.addEventListener('DOMContentLoaded', function() {
    function initScroll(containerId, leftButtonId, rightButtonId) {
        const container = document.getElementById(containerId);
        const leftButton = document.getElementById(leftButtonId);
        const rightButton = document.getElementById(rightButtonId);

        function checkScroll() {
            const scrollLeft = container.scrollLeft;
            const scrollWidth = container.scrollWidth;
            const clientWidth = container.clientWidth;

            leftButton.classList.toggle('hidden', scrollLeft === 0);
            rightButton.classList.toggle('hidden', scrollLeft + clientWidth >= scrollWidth);
        }

        leftButton.addEventListener('click', () => {
            container.scrollBy({ left: -200, behavior: 'smooth' });
        });

        rightButton.addEventListener('click', () => {
            container.scrollBy({ left: 200, behavior: 'smooth' });
        });

        container.addEventListener('scroll', checkScroll);
        window.addEventListener('resize', checkScroll);

        // Initial check
        checkScroll();
    }

    // Inisialisasi semua container
    initScroll('container1', 'scrollLeft1', 'scrollRight1');
    initScroll('container2', 'scrollLeft2', 'scrollRight2');
    initScroll('container3', 'scrollLeft3', 'scrollRight3');
});

const carousel = new bootstrap.Carousel(document.getElementById('heroCarousel'), {
    interval: 3000,
    wrap: true
});