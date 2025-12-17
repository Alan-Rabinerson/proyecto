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
  const verMasBtn = document.getElementsByClassName('btn-ver-mas');
  const usuario = getCookie('user');
  const url = window.location.href;
  // DEBUGGING console.log(usuario);
  // Si el usuario esta logado ocultar el boton de login y mostrar su nombre y avatar
  const loginBtn = document.getElementById('login-btn');
  if (usuario) {
    const userData = JSON.parse(usuario);
    loginBtn.style.display = 'none';
    const userDisplay = document.createElement('div');
    userDisplay.className = 'user-display flex items-center gap-2 cursor-pointer';
    userDisplay.id = 'user-display';
    userDisplay.innerHTML = `
      <img src="/student024/Shop/assets/avatars/avatar.png" alt="Avatar" class="w-8 h-8 rounded-full" id="user-avatar" onClick="location.href='/student024/Shop/backend/views/my_account.php'"   />
      <span class="text-white font-medium"  onClick="location.href='/student024/Shop/backend/views/my_account.php'">${userData.username}</span>
      <button id="logout-btn" class="boton-rojo text-sm"  onClick="location.href='/student024/Shop/backend/login/logout.php'">Logout</button>
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
      if (typeof loadCart === 'function') {
        try { loadCart(); } catch (e) { console.error('Error al cargar el carrito:', e); }
      }
    });
  }

  if (verMasBtn.length > 0) {
    verMasBtn[0].addEventListener('click', () => {
      window.location.href = '/student024/Shop/views/shopping-cart.html';
    });
  }

  if (typeof loadCart === 'function' && !url.includes('shopping-cart.html')) {
    try { loadCart(); } catch (e) { console.error('loadCart error:', e); }
  } else if (!url.includes('shopping-cart.html')){
    // Fallback: petición XHR directa si loadCart no existe
    //DEBUGGING
    //console.log(url)
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        try {
            var resp = JSON.parse(this.responseText);
            if (resp && resp.success && typeof renderCart === 'function') {
              renderCart(resp.items, resp.total);
            }
          } catch (e) { console.error('Error parsing cart response', e); }
      }
    };
    xhr.open('GET', '/student024/Shop/backend/endpoints/shopping_cart/get_cart.php', true);
    xhr.send();
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

  function renderCart(items, total) {
    const list = document.querySelector('.carrito-items');
    if (!list) return;
    // keep header (first li) if present
    const header = list.querySelector(':scope > li:first-child');
    list.innerHTML = '';
    if (header) list.appendChild(header);

    items.forEach(item => {
      const li = document.createElement('li');
      li.className = 'carrito-item';

      li.innerHTML = `
        <img src="${item.image}" alt="${escapeHtml(item.name)}">
        <span class="nombre-producto">${escapeHtml(item.name)}</span>
        <div class="cantidad-container">
          <button class="restar-cantidad" data-product="${item.product_id}" data-size="${escapeHtml(item.size)}">-</button>
          <span class="cantidad-producto">${item.quantity}</span>
          <button class="añadir-cantidad" data-product="${item.product_id}" data-size="${escapeHtml(item.size)}">+</button>
        </div>
        <span class="precio-producto">${Number(item.subtotal).toFixed(2)} €</span>
      `;

      // attach handlers
      li.querySelectorAll('button.restar-cantidad, button.añadir-cantidad').forEach(btn => {
        btn.addEventListener('click', function (e) {
          const pid = this.getAttribute('data-product');
          const size = this.getAttribute('data-size');
          const delta = this.classList.contains('restar-cantidad') ? -1 : 1;
          updateQuantity(pid, size, delta);
        });
      });

      list.appendChild(li);
    });

    // update total if footer element exists
    const totalEl = document.querySelector('.carrito-footer .total-amount');
    if (totalEl) totalEl.textContent = 'Total: ' + Number(total).toFixed(2) + ' €';
  }

  function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>"'`]/g, function (s) {
      return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','`':'&#x60;'})[s];
    });
  }


  
});
