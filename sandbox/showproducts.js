function showProducts(str) {
  let txtHint = document.getElementById("txtHint");
  let output = "";
  if (str.length == 0) {
    txtHint.innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var products = JSON.parse(this.responseText);
        products.forEach(product => {
        output += "<div class='product-card'>" +
                      "<h2>" + product.name + "</h2>" +
                      "<p>Price: " + product.price + "</p>" +
                      "</div>";
        });
        txtHint.innerHTML = output;
      }
    };
    xmlhttp.open("GET", "db_product_search.php?searchTerm=" + str, true);
    xmlhttp.send();
  }
}