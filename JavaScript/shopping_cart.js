let productQty ;
let addQty = document.querySelector(".add-qty");
let removeQty = document.querySelector(".remove-qty");
let cartTotal = document.getElementById("cart-total");
let cartTotalValue = cartTotal.textContent.split(":")[1].trim();
function addQuantity(productId, size, quantity, price) {
    var xmlhttp = new XMLHttpRequest();
    productQty = document.querySelector("#product-" + productId + "-" + size + " #product-quantity-" + productId + "-" + size);
    xmlhttp.onreadystatechange = () => {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            try {
                let resp = JSON.parse(xmlhttp.responseText);
                if (resp.status === 'ok' && resp.item) {
                    let products = resp.item;
                    productQty.textContent = "Quantity: " + products.quantity;
                    cartTotalValue = (parseFloat(cartTotalValue) + parseFloat(price)).toFixed(2) + "€";
                    cartTotal.textContent = "Cart Total: " + cartTotalValue;
                } else if (resp.status === 'deleted') {
                    // item removed from cart server-side
                    let container = document.querySelector("#product-" + productId + "-" + size);
                    if (container) container.remove();
                    cartTotalValue = (parseFloat(cartTotalValue) - parseFloat(price)).toFixed(2) + "€";
                    cartTotal.textContent = "Cart Total: " + cartTotalValue;
                } else if (resp.status === 'error') {
                    console.error('Server error updating cart:', resp.message);
                }
            } catch (e) {
                console.error('Error parsing response from cart update:', e, xmlhttp.responseText);
            }
            
        }
    }
    xmlhttp.open("GET", "/student024/Shop/backend/db/shopping_cart/db_shopping_cart.php?product_id=" + productId + "&size="+ encodeURIComponent(size) + "&action=add&quantity="+ quantity, true);
    xmlhttp.send();
}
    

function removeQuantity(productId, size, quantity, price) {
    productQty = document.querySelector("#product-" + productId + "-" + size + " #product-quantity-" + productId + "-" + size);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = () => {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            try {
                let resp = JSON.parse(xmlhttp.responseText);
                if (resp.status === 'ok' && resp.item) {
                    let products = resp.item;
                    productQty.textContent = "Quantity: " + products.quantity;
                    cartTotalValue = (parseFloat(cartTotalValue) - parseFloat(price)).toFixed(2) + "€";
                    cartTotal.textContent = "Cart Total: " + cartTotalValue;
                    if (products.quantity <= 0) {
                        let container = document.querySelector("#product-" + productId + "-" + size);
                        if (container) container.remove();
                    }
                } else if (resp.status === 'deleted') {
                    let container = document.querySelector("#product-" + productId + "-" + size);
                    if (container) container.remove();
                    cartTotalValue = (parseFloat(cartTotalValue) - parseFloat(price)).toFixed(2) + "€";
                    cartTotal.textContent = "Cart Total: " + cartTotalValue;
                } else if (resp.status === 'error') {
                    console.error('Server error updating cart:', resp.message);
                }
            } catch (e) {
                console.error('Error parsing response from cart update:', e, xmlhttp.responseText);
            }
        }
    }
    xmlhttp.open("GET", "/student024/Shop/backend/db/shopping_cart/db_shopping_cart.php?product_id=" + productId + "&size="+ encodeURIComponent(size) + "&action=remove&quantity="+ quantity, true);
    xmlhttp.send();
}
// student024\Shop\sandbox\db_shopping_cart.php
