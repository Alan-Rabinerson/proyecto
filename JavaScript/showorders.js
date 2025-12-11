function showOrders(str) {
  let divOrders = document.getElementById("orders-container");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      divOrders.innerHTML = this.responseText;
    }
  };
  xmlhttp.open("GET", "/student024/Shop/backend/db/orders/db_orders_search.php?searchTerm=" + str, true);
  xmlhttp.send();
}

function showMyOrders(str) {
  let divOrders = document.getElementById("orders-container");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      divOrders.innerHTML = this.responseText;
    }
  };
  xmlhttp.open("GET", "/student024/Shop/backend/db/orders/db_myorders_search.php?searchTerm=" + str, true);
  xmlhttp.send();
  
}