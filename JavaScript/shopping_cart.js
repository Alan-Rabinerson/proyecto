let productQty ;
let addQty = document.querySelector(".add-qty");
let removeQty = document.querySelector(".remove-qty");
let cartTotal = document.getElementById("cart-total");
let cartTotalValue = cartTotal.textContent.split(":")[1].trim();
function addQuantity(productId, quantity, price) {
    var xmlhttp = new XMLHttpRequest();
    productQty = document.querySelector("#product-" + productId + " #product-quantity");
    xmlhttp.onreadystatechange = () => {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let products = JSON.parse(xmlhttp.responseText)[0];
            productQty.textContent = "Quantity: " + products.quantity;
            cartTotalValue = (parseFloat(cartTotalValue) + parseFloat(price)).toFixed(2) + "€";
            cartTotal.textContent = "Cart Total: " + cartTotalValue;
        }
    }
    xmlhttp.open("GET", "/student024/Shop/backend/db/shopping_cart/db_shopping_cart.php?product_id=" + productId + "&action=add&quantity="+ quantity, true);
    xmlhttp.send();
}
    

function removeQuantity(productId, quantity, price) {
    productQty = document.querySelector("#product-" + productId + " #product-quantity");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = () => {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let products = JSON.parse(xmlhttp.responseText)[0];
            productQty.textContent = "Quantity: " + products.quantity;
            console.log(products)
            cartTotalValue = (parseFloat(cartTotalValue) - parseFloat(price)).toFixed(2) + "€";
            cartTotal.textContent = "Cart Total: " + cartTotalValue;
        }
    }
    xmlhttp.open("GET", "/student024/Shop/backend/db/shopping_cart/db_shopping_cart.php?product_id=" + productId + "&action=remove&quantity="+ quantity, true);
    xmlhttp.send();
}
// student024\Shop\sandbox\db_shopping_cart.php
