let addtoCartForms = document.querySelectorAll(".add-to-cart-form");
addtoCartForms.forEach(form => {
    form.addEventListener("submit", (event) => {
        event.preventDefault(); // prevent form submission
        let productId = form.querySelector("input[name='product_id']").value;
        var params = "product_id=" + encodeURIComponent(productId)+ "&quantity=" + encodeURIComponent(1);
        console.log("añadir al carrito")
        //crear objeto xhttprequest
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "/student024/Shop/sandbox/db_shopping_cart_insert.php", true);

        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               let mensaje = "Producto añadido al carrito correctamente.";
            }
        };
        xhttp.send(params);
        

    });
});
