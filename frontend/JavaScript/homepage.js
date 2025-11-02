document.addEventListener("DOMContentLoaded", () => {
    const carrito = document.querySelector('.carrito');
    const stickyCart = document.querySelector('.sticky-cart');
    const cerrarCarrito = document.getElementById('close-cart');
    const carritoDesktop = document.querySelector('.menu-links li img[src="./assets/logos/carrito_blanco.png"]');

    // Seguridad: comprobar que los elementos existen antes de añadir handlers
    if (carrito) {
        if (stickyCart) {
            stickyCart.addEventListener('click', () => {
                carrito.classList.toggle('active');
            });
        }

        if (cerrarCarrito) {
            cerrarCarrito.addEventListener('click', () => {
                carrito.classList.remove('active');
            });
        }

        if (carritoDesktop) {
            carritoDesktop.addEventListener('click', () => {
                carrito.classList.toggle('active');
            });
        }
    }

    const sliderContainers = document.querySelectorAll('.slider-container');
    sliderContainers.forEach(container => {
        const slider = container.querySelector('.products-slider, .offers-slider');
        const next = container.querySelector('.slider-next');
        const prev = container.querySelector('.slider-prev');

        

        // Calcular cuánto desplazar por clic: preferir ancho de tarjeta si existe
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