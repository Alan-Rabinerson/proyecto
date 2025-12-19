document.addEventListener("DOMContentLoaded", () => {
    // Cargar productos destacados
    loadFeaturedProducts();
    
    // Cargar ofertas semanales
    loadWeeklyOffers();

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

// Función para cargar productos destacados desde la base de datos usando XMLHttpRequest
function loadFeaturedProducts() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', './backend/endpoints/homepage/show_products.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState !== 4) return;
        const productsSlider = document.querySelector('.featured-products .products-slider');
        if (!productsSlider) return;

        if (xhr.status === 200) {
            try {
                const products = JSON.parse(xhr.responseText);
                productsSlider.innerHTML = '';
                products.forEach(product => {
                    const productCard = document.createElement('div');
                    productCard.className = 'product-card';
                    productCard.dataset.productId = product.product_id;

                    productCard.innerHTML = `
                        <img src="./assets/imagenes/foto${product.product_id}.jpg" alt="${product.product_name}">
                        <h3>${product.product_name}</h3>
                        <p class="price">${product.price.toFixed(2)} €</p>
                        `
                    
                    const sizes = product.sizes.split(',');
                    let sizeOptions = `<label for="size-select-${product.product_id}">Talla:</label>
                        <select id="size-select-${product.product_id}" class="size-select">`;
                    sizes.forEach(element => {
                        sizeOptions += `
                         <option value="${element}">${element}</option>
                        `;
                    });
                    sizeOptions += `</select>`;
                    productCard.innerHTML += sizeOptions;
                        
                    productCard.innerHTML+=    
                        `
                        <button class="btn-comprar-ahora">Comprar</button>
                        <button class="btn-add-cart">Añadir al carrito</button>
                    `;

                    productCard.addEventListener('click', (e) => {
                        if (!e.target.classList.contains('btn-comprar-ahora') && 
                            !e.target.classList.contains('btn-add-cart') && !e.target.classList.contains('size-select')) {
                            e.stopPropagation();
                            window.location.href = `./views/producto.html?id=${product.product_id}`;
                        }
                    });

                    // Agregar event listener al botón "Añadir al carrito"
                    const addCartBtn = productCard.querySelector('.btn-add-cart');
                    addCartBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const productId = productCard.dataset.productId;
                        const sizeSelect = productCard.querySelector('.size-select');
                        const selectedSize = sizeSelect ? sizeSelect.value : 'M';
                        // DEBUGGING console.log('Añadiendo producto:', productId, 'talla:', selectedSize);
                        addToCart(productId, 1, selectedSize);
                    });

                    productsSlider.appendChild(productCard);
                });
            } catch (err) {
                console.error('Error parsing featured products response as JSON:', err);
                console.error('Response text:', xhr.responseText);
            }
        } else {
            console.error('Server returned status', xhr.status, 'for show_products.php');
            console.error('Response text:', xhr.responseText);
        }
    };
    xhr.send();
}

// Función para cargar ofertas semanales usando XMLHttpRequest
function loadWeeklyOffers() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', './backend/endpoints/homepage/show_offers.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState !== 4) return;
        const offersSlider = document.querySelector('.weekly-offers .offers-slider');
        if (!offersSlider) return;

        if (xhr.status === 200) {
            try {
                const offers = JSON.parse(xhr.responseText);
                offersSlider.innerHTML = '';
                offers.forEach(offer => {
                    const offerCard = document.createElement('div');
                    offerCard.className = 'product-card offer';
                    offerCard.style.cursor = 'pointer';
                    offerCard.dataset.productId = offer.product_id;

                    offerCard.innerHTML = `
                        <div class="discount-badge">-${offer.discount_percent}%</div>
                        <img src="./assets/imagenes/foto${offer.product_id}.jpg" alt="${offer.product_name}">
                        <h3>${offer.product_name}</h3>
                        <p class="old-price">${offer.original_price} €</p>
                        <p class="new-price">${offer.price} €</p>`
                    const sizes = offer.sizes.split(',');
                    let sizeOptions = `<label for="size-select-${offer.product_id}">Talla:</label>
                        <select id="size-select-${offer.product_id}" class="size-select">`;
                    sizes.forEach(element => {
                        sizeOptions += `
                         <option value="${element}">${element}</option>
                        `;
                    });
                    sizeOptions += `</select>`;       
                    offerCard.innerHTML += sizeOptions;                 
                    offerCard.innerHTML +=
                       `<button class="btn-comprar-ahora">Comprar</button>
                        <button class="btn-add-cart">Añadir al carrito</button>
                    `;

                    offerCard.addEventListener('click', (e) => {
                        if (!e.target.classList.contains('btn-comprar-ahora') && 
                            !e.target.classList.contains('btn-add-cart') && !e.target.classList.contains('size-select')) {
                            e.stopPropagation();
                            window.location.href = `./views/producto.html?id=${offer.product_id}`;
                        }
                    });

                    // Agregar event listener al botón "Añadir al carrito"
                    const addCartBtn = offerCard.querySelector('.btn-add-cart');
                    addCartBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const productId = offerCard.dataset.productId;
                        const sizeSelect = offerCard.querySelector('.size-select');
                        const selectedSize = sizeSelect ? sizeSelect.value : 'M';
                        // DEBUGGING console.log('Añadiendo oferta:', productId, 'talla:', selectedSize);
                        addToCart(productId, 1, selectedSize);
                    });

                    offersSlider.appendChild(offerCard);
                });
            } catch (err) {
                console.error('Error parsing weekly offers response as JSON:', err);
                console.error('Response text:', xhr.responseText);
            }
        } else {
            console.error('Server returned status', xhr.status, 'for show_offers.php');
            console.error('Response text:', xhr.responseText);
        }
    };
    xhr.send();
}