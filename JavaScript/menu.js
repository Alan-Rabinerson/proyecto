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

  // Evento para abrir el menú móvil
  menuButton.addEventListener('click', function () {
    mobileMenu.classList.add('active');
    menuLinks.classList.add('active');
    // console.log("menu") DEBUGGING
    menuButton.setAttribute('aria-expanded', 'true');
  });
  
  // Evento para cerrar el menú móvil

  closeButton.addEventListener('click', function () {
    mobileMenu.classList.remove('active');
    menuLinks.classList.remove('active');
    });
  

  // Eeventos para abrir y cerrar el carrito
    
  if (stickyCart) {
    stickyCart.addEventListener('click', () => {
      carrito.classList.add('active');
      // console.log("carrito") DEBUGGING
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
   //Funcionalidad no implementada para que al hacer click en los botones de añadir o restar cantidad en el carrito, se modifique el valor del input de cantidad y el total del producto
  // añadirCantidadBtn.forEach(button => {
  //   button.addEventListener('click', () => {
  //     const cantidadInput = document.getElementById('cantidad');
  //     let currentValue = parseInt(cantidadInput.value);
  //     cantidadInput.value = currentValue + 1;
  //     const precioProducto = document.querySelector('.precio-producto').textContent.split(' ')[0];
  //   });

  // }); 
  // restarCantidadBtn.forEach(button => {
  //   button.addEventListener('click', () => {
  //     const cantidadInput = document.getElementById('cantidad');
  //     let currentValue = parseInt(cantidadInput.value);
  //     if (currentValue > 1) {
  //       cantidadInput.value = currentValue - 1;
  //     } else {
        
  //     }
  //   }); 
  // });
});