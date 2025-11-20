document.addEventListener("DOMContentLoaded", () => {
    const productCards = document.querySelectorAll('.product-card');

    // Agregar ruta de producto a cada tarjeta de producto
    productCards.forEach(card => {
        card.addEventListener('click', () => {
            window.location.href = './views/producto.html';
        });
    });


    // Slider de productos y ofertas
    const sliderContainers = document.querySelectorAll('.slider-container');
    sliderContainers.forEach(container => {
        const slider = container.querySelector('.products-slider, .offers-slider');
        const next = container.querySelector('.slider-next');
        const prev = container.querySelector('.slider-prev');

        

        // Función para calcular la cantidad de desplazamiento
        // esta parte esta sacada de stackoverflow y modificada segun lo que necesito
        const computeScroll = () => {
            const card = slider.querySelector('.product-card');
            if (card) {
                const gap = parseInt(getComputedStyle(slider).gap || 16, 10) || 16;
                return card.clientWidth + gap;
            }
            return Math.floor(slider.clientWidth * 0.75);
        };

        const scrollByAmount = () => computeScroll();

        if (next) {
            next.addEventListener('click', () => {
                slider.scrollBy({ left: scrollByAmount(), behavior: 'smooth' });
            });
        }

        if (prev) {
            prev.addEventListener('click', () => {
                slider.scrollBy({ left: -scrollByAmount(), behavior: 'smooth' });
            });
        }
    });
});