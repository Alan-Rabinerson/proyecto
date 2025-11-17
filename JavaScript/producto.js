let divproductImages = document.querySelector('.product-images');
let mainImage = divproductImages.querySelector('img');
let additionalImages = divproductImages.querySelectorAll('.additional-images img');

additionalImages.forEach(image => {
    image.addEventListener('click', () => {
        imagenPrincipal = mainImage.src;
        mainImage.src = image.src;
        image.src = imagenPrincipal;
    });

    image.addEventListener('mouseover', () => {
        image.classList.add('border', 'border-azul-claro');
    });
    image.addEventListener('mouseout', () => {
        image.classList.remove('border', 'border-azul-claro');
    });
});

mainImage.addEventListener('mouseover', () => {
    mainImage.classList.add('border', 'border-azul-claro');
});
mainImage.addEventListener('mouseout', () => {
    mainImage.classList.remove('border', 'border-azul-claro');
});