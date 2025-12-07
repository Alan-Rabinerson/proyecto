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
  const checkoutBtn = document.getElementsByClassName('btn-checkout');
  const usuario = getCookie('user');
  console.log(usuario);
  // Si el usuario esta logado ocultar el boton de login y mostrar su nombre y avatar
  const loginBtn = document.getElementById('login-btn');
  if (usuario) {
    const userData = JSON.parse(usuario);
    loginBtn.style.display = 'none';
    const userDisplay = document.createElement('div');
    userDisplay.className = 'user-display flex items-center gap-2 cursor-pointer';
    userDisplay.id = 'user-display';
    userDisplay.innerHTML = `
      <img src="/student024/shop/assets/avatars/avatar.png" alt="Avatar" class="w-8 h-8 rounded-full" id="user-avatar" />
      <span class="text-white font-medium">${userData.username}</span>
      <button id="logout-btn" class="boton-rojo text-sm">Logout</button>
    `;
    loginBtn.parentNode.appendChild(userDisplay);
    //console.log(userData.username)

  }

  // Evento para abrir el menú móvil
  menuButton.addEventListener('click', function () {
    mobileMenu.classList.add('active');
    menuLinks.classList.add('active');
    menuButton.style.display = 'none';
    // console.log("menu") DEBUGGING
  });
  
  // Evento para cerrar el menú móvil
  closeButton.addEventListener('click', function () {
    mobileMenu.classList.remove('active');
    menuLinks.classList.remove('active');
    menuButton.style.display = 'block';
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

  if (checkoutBtn.length > 0) {
    checkoutBtn[0].addEventListener('click', () => {
      window.location.href = './views/shopping-cart.html';
    });
  }





  function getCookie(cname) { // funcion de w3schools para obtener cookies
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
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