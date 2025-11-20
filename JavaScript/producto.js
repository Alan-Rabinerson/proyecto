let divproductImages = document.querySelector('.product-images');
let mainImage = divproductImages.querySelector('img');
let additionalImages = divproductImages.querySelectorAll('.additional-images img');
let anadirCarritoBtn = document.getElementById('añadir-carrito-btn');
let crtCount = document.querySelector('.cart-count');

additionalImages.forEach(image => {
    image.addEventListener('click', () => {
        imagenPrincipal = mainImage.src;
        mainImage.src = image.src;
        image.src = imagenPrincipal;
    });

});

anadirCarritoBtn.addEventListener('click', (e) => {
    e.preventDefault();
    let currentCount = parseInt(crtCount.textContent);
    let cantidad = parseInt(document.getElementById('cantidad').value);
    crtCount.textContent = currentCount + cantidad;
    console.log("Añadido al carrito");
});


