document.addEventListener("DOMContentLoaded", function () {
  const menuButton = document.querySelector('.menu-toggle');
  const closeButton = document.getElementById('close-menu');
  const mobileMenu = document.getElementById('mobile-menu');
  const menuLinks = document.querySelector('.menu-links');
  const carrito = document.querySelector('.carrito');
  const stickyCart = document.querySelectorAll('.sticky-cart')[1];
  const cerrarCarrito = document.getElementById('close-cart');
  const carritoDesktop = document.querySelector('.menu-links .carrito-desktop');
  const añadirCantidadBtn = document.querySelectorAll('.añadir-cantidad');
  const restarCantidadBtn = document.querySelectorAll('.restar-cantidad');


  // Seguridad: si no existe el elemento, evitar errores

    menuButton.addEventListener('click', function () {
      mobileMenu.classList.add('active');
      menuLinks.classList.add('active');
      console.log("menu")
      menuButton.setAttribute('aria-expanded', 'true');
    });
  

  if (closeButton && mobileMenu) {
    closeButton.addEventListener('click', function () {
      mobileMenu.classList.remove('active');
      menuLinks.classList.remove('active');
    });
  }

    // Comprobar que los elementos existen antes de añadir eventos
    
  if (stickyCart) {
    stickyCart.addEventListener('click', () => {
      carrito.classList.add('active');
      console.log("carrito")
    });
  }

  if (cerrarCarrito) {
    cerrarCarrito.addEventListener('click', () => {
      carrito.classList.remove('active');
    });
  }

  if (carritoDesktop) {
    carritoDesktop.addEventListener('click', () => {
      carrito.classList.add('active');
    });
  }

  añadirCantidadBtn.forEach(button => {
    button.addEventListener('click', () => {
      const cantidadInput = document.getElementById('cantidad');
      let currentValue = parseInt(cantidadInput.value);
      cantidadInput.value = currentValue + 1;
      const precioProducto = document.querySelector('.precio-producto').textContent;
    });

  }); 
  restarCantidadBtn.forEach(button => {
    button.addEventListener('click', () => {
      const cantidadInput = document.getElementById('cantidad');
      let currentValue = parseInt(cantidadInput.value);
      if (currentValue > 1) {
        cantidadInput.value = currentValue - 1;
      } else {
        
      }
    }); 
  });
});