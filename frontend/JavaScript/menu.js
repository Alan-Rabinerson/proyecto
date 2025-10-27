document.addEventListener("DOMContentLoaded", function () {
  const menuButton = document.querySelector('.menu-toggle');
  const closeButton = document.getElementById('close-menu');
  const mobileMenu = document.getElementById('mobile-menu');

  // Seguridad: si no existe el elemento, evitar errores
  if (menuButton && mobileMenu) {
    menuButton.addEventListener('click', function () {
      mobileMenu.classList.add('active');
      menuButton.setAttribute('aria-expanded', 'true');
    });
  }

  if (closeButton && mobileMenu) {
    closeButton.addEventListener('click', function () {
      mobileMenu.classList.remove('active');
      if (menuButton) menuButton.setAttribute('aria-expanded', 'false');
    });
  }
});