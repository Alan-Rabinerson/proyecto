function addQuantity() {
    let cartItemsDiv = document.getElementById("cart-items");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = () => {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let products = JSON.parse(xmlhttp.responseText);
            cartItemsDiv.innerHTML = products.map(product => `<div>${product.name}</div>`).join('');
        }
    };
    xmlhttp.open("GET", "/student024/shop/backend/sandbox/db_shopping_cart.php", true);
    xmlhttp.send();
}