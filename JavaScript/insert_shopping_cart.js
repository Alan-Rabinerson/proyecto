let addtoCartForms = document.querySelectorAll(".add-to-cart-form"); 
let elementoMensaje = document.createElement("div"); 
addtoCartForms.forEach(form => {
    form.addEventListener("submit", (event) => {
        event.preventDefault(); // prevent form submission
        let productId = form.querySelector("input[name='product_id']").value;
        var params = "product_id=" + encodeURIComponent(productId)+ "&quantity=" + encodeURIComponent(1);
        console.log("añadir al carrito")
        //crear objeto xhttprequest
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "/student024/Shop/backend/db/shopping_cart/db_shopping_cart_insert.php", true);

        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        xhttp.onreadystatechange = function() {
            console.log(xhttp);
            if (this.readyState == 4 && this.status == 200) { 
               
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
            }
        };
        xhttp.send(params);
        

    });
});

