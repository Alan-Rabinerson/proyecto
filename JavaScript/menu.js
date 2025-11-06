document.addEventListener("DOMContentLoaded", function () {
  const menuButton = document.querySelector('.menu-toggle');
  const closeButton = document.getElementById('close-menu');
  const mobileMenu = document.getElementById('mobile-menu');
  const menuLinks = document.querySelector('.menu-links');


  // Seguridad: si no existe el elemento, evitar errores

    menuButton.addEventListener('click', function () {
      mobileMenu.classList.add('active');
      menuLinks.classList.add('active');
      menuButton.setAttribute('aria-expanded', 'true');
    });
  

  if (closeButton && mobileMenu) {
    closeButton.addEventListener('click', function () {
      mobileMenu.classList.remove('active');
      menuLinks.classList.remove('active');
    });
  }
});