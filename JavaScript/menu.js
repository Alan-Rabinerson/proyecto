document.addEventListener("DOMContentLoaded", function () {
  const menuButton = document.querySelector(".menu-toggle");
  const closeButton = document.getElementById("close-menu");
  const mobileMenu = document.getElementById("mobile-menu");
  const menuLinks = document.querySelector(".menu-links");
  const carrito = document.querySelector(".carrito");
  const stickyCart = document.querySelectorAll(".sticky-cart")[1];
  const cerrarCarrito = document.getElementById("close-cart");
  const carritoDesktop = document.querySelector(".menu-links .carrito-desktop");
  const verMasBtn = document.getElementsByClassName("btn-ver-mas");
  const logo = document.getElementsByClassName("logo");
  const addToCartButtons = document.getElementsByClassName("add-to-cart-btn");
  const productId = new URLSearchParams(window.location.search).get("id");
  const size = document.querySelector(".size-select:checked")
    ? document.querySelector(".size-select:checked").value
    : "M";
  const fotoCarrito = document.querySelectorAll(".carrito-item img");
  let elementoMensaje = document.createElement("div");

  // Obtener customer_id: primero desde user cookie (JSON), si no existe desde guest_id (número simple)
  let userData = null;
  let customer_id = null;
  let isGuest = false;

  const userCookie = getCookie("user");
  const guestCookie = getCookie("guest_id");

  if (userCookie) {
    try {
      userData = JSON.parse(userCookie);
      customer_id = userData.customer_id;
    } catch (e) {
      console.warn("Error parseando user cookie:", e);
    }
  } else if (guestCookie) {
    // guest_id es un número simple, no JSON
    customer_id = guestCookie;
    isGuest = true;
    userData = { customer_id: guestCookie, username: "guest_" + guestCookie };
  }

  console.log("Customer ID:", customer_id, "Is Guest:", isGuest);

  // Si el usuario está logado ocultar el botón de login y mostrar su nombre y avatar
  const loginBtn = document.getElementById("login-btn");
  if (userData && !isGuest) {
    // Exponer cookie 'username' y 'customer_id' para que los endpoints PHP los reconozcan
    try {
      if (userData.username)
        document.cookie =
          "username=" + encodeURIComponent(userData.username) + "; path=/";
      if (userData.customer_id)
        document.cookie =
          "customer_id=" +
          encodeURIComponent(userData.customer_id) +
          "; path=/";
    } catch (e) {
      console.warn("No se pudo setear cookie auxiliar username/customer_id", e);
    }
    loginBtn.style.display = "none";
    const userDisplay = document.createElement("div");
    userDisplay.className =
      "user-display flex items-center gap-2 cursor-pointer";
    userDisplay.id = "user-display";
    userDisplay.innerHTML = `
      <img src="/student024/Shop/assets/avatars/avatar.png" alt="Avatar" class="w-8 h-8 rounded-full" id="user-avatar" onClick="location.href='/student024/Shop/backend/views/my_account.php'"   />
      <span class="text-white font-medium"  onClick="location.href='/student024/Shop/backend/views/my_account.php'">${userData.username}</span>
      <button id="logout-btn" class="boton-rojo text-sm"  onClick="location.href='/student024/Shop/backend/login/logout.php'">Logout</button>
    `;
    loginBtn.parentNode.appendChild(userDisplay);
    //console.log(userData.username)
  }

  // evento para redirigir al home al hacer click en el logo
  if (logo.length > 0) {
    logo[0].addEventListener("click", () => {
      window.location.href = "/student024/Shop/index.html";
    });
  }

  // Evento para abrir el menú móvil
  menuButton.addEventListener("click", function () {
    mobileMenu.classList.add("active");
    menuLinks.classList.add("active");
    menuButton.style.display = "none";
    // console.log("menu") DEBUGGING
  });

  // Evento para cerrar el menú móvil
  closeButton.addEventListener("click", function () {
    mobileMenu.classList.remove("active");
    menuLinks.classList.remove("active");
    menuButton.style.display = "block";
  });

  // Eeventos para abrir y cerrar el carrito

  if (stickyCart) {
    stickyCart.addEventListener("click", () => {
      carrito.classList.add("active");
      // console.log("carrito") DEBUGGING
    });
  }

  if (cerrarCarrito) {
    cerrarCarrito.addEventListener("click", () => {
      carrito.classList.remove("active");
    });
  }

  if (carritoDesktop) {
    carritoDesktop.addEventListener("click", () => {
      carrito.classList.add("active");
      if (typeof loadCart === "function") {
        try {
          loadCart();
        } catch (e) {
          console.error("Error al cargar el carrito:", e);
        }
      }
    });
  }

  if (verMasBtn.length > 0) {
    verMasBtn[0].addEventListener("click", () => {
      window.location.href = "/student024/Shop/views/shopping-cart.html";
    });
  }

  if (addToCartButtons.length > 0) {
    Array.from(addToCartButtons).forEach((button) => {
      button.addEventListener("click", () => {
        addToCart(productId, 1, size);
      });
    });
  }

  if (fotoCarrito.length > 0) {
    Array.from(fotoCarrito).forEach((img) => {
      img.addEventListener("click", () => {
        window.location.href =
          "/student024/Shop/views/product.html?id=" +
          img.parentElement.getAttribute("data-product");
      });
    });
  }

  if (typeof loadCart === "function") {
    try {
      loadCart();
    } catch (e) {
      console.error("loadCart error:", e);
    }
  } else {
    // Fallback: petición XHR directa si loadCart no existe
    loadCartFromServer();
  }

  function loadCartFromServer() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
        try {
          var resp = JSON.parse(this.responseText);
          if (resp && resp.success && typeof renderCart === "function") {
            renderCart(resp.items, resp.total);
          }
        } catch (e) {
          console.error("Error parsing cart response", e);
        }
      }
    };
    xhr.open(
      "GET",
      "/student024/Shop/backend/endpoints/shopping_cart/get_cart.php",
      true,
    );
    xhr.send();
  }

  function getCookie(cname) {
    // funcion de w3schools para obtener cookies
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(";");

    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == " ") {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        let cookieValue = c.substring(name.length, c.length);
        // Intentar decodificar si es URI encoded
        try {
          return decodeURIComponent(cookieValue);
        } catch (e) {
          return cookieValue;
        }
      }
    }
    return "";
  }

  function renderCart(items, total) {
    const list = document.querySelector(".carrito-items");
    if (!list) return;
    // DEBUG: mostrar items recibidos
    //try { console.log('renderCart items:', items, 'total:', total); } catch(e){}
    // mantener el header "Carrito Vacío" si existe y el boton de "Ver Más"
    let verMasBtn = list.querySelector("button.btn-ver-mas");
    list.innerHTML = "";
    if (verMasBtn) {
      const verMasLi = document.createElement("li");
      verMasLi.classList.add("flex", "justify-center", "mt-4");
      verMasLi.appendChild(verMasBtn);
      list.appendChild(verMasLi);
    }

    Object.values(items).forEach((item) => {
      const li = document.createElement("li");
      li.className = "carrito-item";
      // mark li for product/size so we can find related buttons across duplicates
      li.setAttribute("data-product", item.product_id);
      li.setAttribute("data-size", item.size || "");

      li.innerHTML = `
        <img src="${item.image}" alt="${escapeHtml(item.name)}">
        <span class="nombre-producto">${escapeHtml(item.name)}</span>
        <span class="talla-producto p-2">Talla: ${escapeHtml(item.size)}</span>
        <div class="cantidad-container">
          <button class="restar-cantidad" data-product="${
            item.product_id
          }" data-size="${escapeHtml(item.size)}">-</button>
          <span class="cantidad-producto">${item.quantity}</span>
          <button class="añadir-cantidad" data-product="${
            item.product_id
          }" data-size="${escapeHtml(item.size)}">+</button>
        </div>
        <span class="precio-producto">${Number(item.subtotal).toFixed(
          2,
        )} €</span>
        <button class="eliminar-producto" data-product="${
          item.product_id
        }" data-size="${escapeHtml(item.size)}" onClick="updateQuantity('${
          item.product_id
        }', '${escapeHtml(item.size)}', -${
          item.quantity
        }); event.stopPropagation();">×</button>
      `;

      // Añadir un único listener por botón para evitar duplicados
      const restBtn = li.querySelector("button.restar-cantidad");
      const addBtn = li.querySelector("button.añadir-cantidad");
      if (restBtn) {
        restBtn.addEventListener("click", function (e) {
          e.preventDefault();
          const pid = this.getAttribute("data-product");
          const size = this.getAttribute("data-size");
          updateQuantity(pid, size, -1, this);
        });
      }
      if (addBtn) {
        addBtn.addEventListener("click", function (e) {
          e.preventDefault();
          const pid = this.getAttribute("data-product");
          const size = this.getAttribute("data-size");
          updateQuantity(pid, size, 1, this);
        });
      }

      list.appendChild(li);
    });

    // actualizar total carrito
    const totalEl = document.querySelector(".carrito-footer .total-amount");
    if (totalEl)
      totalEl.textContent = "Total: " + Number(total).toFixed(2) + " €";
    // actualizar contador carrito en el menú
    const cartCountEl = document.querySelector(".cart-count");
    if (cartCountEl)
      cartCountEl.textContent = Object.values(items).reduce(
        (sum, it) => sum + Number(it.quantity),
        0,
      );
  }

  function escapeHtml(str) {
    if (!str) return "";
    return String(str).replace(/[&<>"'`]/g, function (s) {
      return {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#39;",
        "`": "&#x60;",
      }[s];
    });
  }

  function updateQuantity(productId, size, delta) {
    //console.log('updateQuantity', productId, size, delta);

    var xhr = new XMLHttpRequest();
    xhr.open(
      "POST",
      "/student024/Shop/backend/endpoints/shopping_cart/update_quantity.php",
      true,
    );
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (this.readyState === 4) {
        if (this.status === 200) {
          try {
            var resp = JSON.parse(this.responseText);
            //console.log('updateQuantity response:', resp); // DEBUGGING
            if (resp && resp.success && typeof renderCart === "function") {
              renderCart(resp.items, resp.total);
            }
          } catch (e) {
            console.error(
              "Error parsing update quantity response:",
              e,
              "\nresponseText:",
              this.responseText,
            );
          }
        } else {
          console.error(
            "updateQuantity XHR error, status:",
            this.status,
            "response:",
            this.responseText,
          );
        }
      }
    };
    xhr.send(
      "product_id=" +
        encodeURIComponent(productId) +
        "&size=" +
        encodeURIComponent(size) +
        "&delta=" +
        encodeURIComponent(delta),
    );
  }
  function addToCart(productId, quantity, size) {
    // Usar window.customer_id si la variable local no está disponible
    const cid = customer_id || window.customer_id;

    if (!cid) {
      console.error(
        "customer_id no disponible. No se puede añadir al carrito.",
      );
      return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open(
      "POST",
      "/student024/Shop/backend/db/shopping_cart/db_shopping_cart_insert.php",
      true,
    );
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState !== 4) return;
      if (xhr.status === 200) {
        try {
          const response = JSON.parse(xhr.responseText);
          if (response.success) {
            // DEBUGGING console.log('Producto añadido al carrito exitosamente. Customer ID:', cid);
            // Recargar el carrito inmediatamente después de añadir
            loadCartFromServer();
            // Mostrar mensaje de éxito
            elementoMensaje.innerText = JSON.parse(this.responseText).message;
            elementoMensaje.style.position = "fixed";
            elementoMensaje.style.bottom = "20px";
            elementoMensaje.style.right = "20px";
            elementoMensaje.style.backgroundColor = "#4BB543";
            elementoMensaje.style.color = "white";
            elementoMensaje.style.padding = "10px";
            elementoMensaje.style.borderRadius = "5px";
            elementoMensaje.style.boxShadow = "0 2px 6px rgba(0, 0, 0, 0.3)";
            document.body.appendChild(elementoMensaje);
            setTimeout(() => {
              document.body.removeChild(elementoMensaje);
            }, 5000);
          } else {
            console.error(
              "Error al añadir el producto al carrito: " + response.message,
            );
            // Mostrar mensaje de error
            elementoMensaje.innerText = JSON.parse(this.responseText).message;
            elementoMensaje.style.position = "fixed";
            elementoMensaje.style.bottom = "20px";
            elementoMensaje.style.right = "20px";
            elementoMensaje.style.backgroundColor = "#FF4C4C";
            elementoMensaje.style.color = "white";
            elementoMensaje.style.padding = "10px";
            elementoMensaje.style.borderRadius = "5px";
            elementoMensaje.style.boxShadow = "0 2px 6px rgba(0, 0, 0, 0.3)";
            document.body.appendChild(elementoMensaje);
            setTimeout(() => {
              document.body.removeChild(elementoMensaje);
            }, 5000);
          }
        } catch (err) {
          console.error("Error parsing add to cart response as JSON:", err);
          console.error("Response text:", xhr.responseText);
        }
      } else {
        console.error(
          "Server returned status",
          xhr.status,
          "for db_shopping_cart_insert.php",
        );
        console.error("Response text:", xhr.responseText);
      }
    };
    // DEBUGGING console.log('Enviando addToCart:', { productId, quantity, size, customer_id: cid });
    xhr.send(
      "product_id=" +
        encodeURIComponent(productId) +
        "&quantity=" +
        encodeURIComponent(quantity) +
        "&size=" +
        encodeURIComponent(size) +
        "&customer_id=" +
        encodeURIComponent(cid),
    );
  }

  // Hacer accesibles algunas funciones y variables desde el scope global para los manejadores inline
  try {
    window.updateQuantity = updateQuantity;
    window.renderCart = renderCart;
    window.escapeHtml = escapeHtml;
    window.addToCart = addToCart;
    window.loadCartFromServer = loadCartFromServer;
    window.customer_id = customer_id;
    window.userData = userData;
    window.isGuest = isGuest;
    // DEBUGGING console.log('Global variables set: customer_id=', window.customer_id, 'isGuest=', window.isGuest);
  } catch (e) {
    console.warn("No se pudieron exportar funciones al scope global:", e);
  }
});
