let productQty = document.getElementById("product-quantity");
let addQty = document.querySelector(".add-qty");
let removeQty = document.querySelector(".remove-qty");
let totalItemsSpan = document.getElementById("total-items");
let cartTotalSpan = document.getElementById("cart-total");
function addQuantity(event) {
    var xmlhttp = new XMLHttpRequest();
    event.preventDefault();
    xmlhttp.onreadystatechange = () => {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let products = JSON.parse(xmlhttp.responseText);
            parseInt(totalItemsSpan.textContent) ++;
            cartTotalSpan.textContent = (parseFloat(cartTotalSpan.textContent) + parseFloat(products.price)).toFixed(2) + "€";
        }
    }
    xmlhttp.open("GET", "/student024/shop/backend/sandbox/db_shopping_cart.php?", true);
    xmlhttp.send();
}
    

function removeQuantity(event) {
    var xmlhttp = new XMLHttpRequest();
    event.preventDefault();
    xmlhttp.onreadystatechange = () => {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let products = JSON.parse(xmlhttp.responseText);
            cartItemsDiv.innerHTML = products.map(product => `<div>${product.name}</div>`).join('');
        }
    }
    xmlhttp.open("GET", "/student024/shop/backend/sandbox/db_shopping_cart.php", true);
    xmlhttp.send();
}

