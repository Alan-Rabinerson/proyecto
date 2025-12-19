document.addEventListener("DOMContentLoaded", () => {
  // comprobar si existe una coookie de usuario
  const usuario = getCookie("user") ?? null;
  let guestId = getCookie("guest_id") ?? null;
  if (!usuario && !guestId) {
    // si no existe usuario crear invitado en la base de datos primero
    const today = parseInt(Date.now().toString().slice(0, 9));
    const tempGuestId = Math.floor(Math.random() * 100) + today;
    // DEBUGGING console.log('Creando guest con tempId:', tempGuestId);
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          // DEBUGGING console.log('Guest creation response:', this.responseText);
          try {
            const response = JSON.parse(this.responseText);
            if (response.success && response.customer_id) {
              // Usar el customer_id devuelto por el servidor
              guestId = response.customer_id;
              document.cookie = "guest_id=" + guestId + "; path=/; max-age=" + 60 * 60 * 24 * 7; // 7 dias
              // DEBUGGING console.log("Bienvenido invitado. Customer ID: " + guestId);
            } else {
              console.error('Error creando guest:', response.message);
            }
          } catch (e) {
            console.error('Error parsing guest creation response:', e);
          }
        } else {
          console.error("Error al crear el invitado en la base de datos.");
        }
      }
    };
    xhr.open(
      "POST",
      "/student024/Shop/backend/endpoints/guests/create_guest.php",
      true
    );

    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("guest_id=" + encodeURIComponent(tempGuestId));
  }
});
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
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
