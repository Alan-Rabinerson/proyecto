function showCustomers(str) {
  let divProducts = document.getElementById("customer-list");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      // var output = "";
      // var products = JSON.parse(this.responseText);
      // products.forEach(function(product) {
      //   output += "<div class='product-card'>" +
      //               "<h2>" + product.name + "</h2>" +
      //               "<p>Price: " + product.price + "</p>" +
      //               "</div>";
      // });
      // divProducts.innerHTML = output;
      divProducts.innerHTML = this.responseText;
    }
  };
  xmlhttp.open("GET", "/student024/Shop/sandbox/db_customer_search.php?searchTerm=" + str, true);
  xmlhttp.send();
  
}