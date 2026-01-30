var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function () {
  if (this.readyState == 4) {
    if (this.status == 200) {
      // Log raw response for debugging (useful when server returns HTML/error)
      //console.log('Raw response:', this.responseText);
      try {
        var sellersData = JSON.parse(this.responseText);
        console.log(sellersData);
      } catch (e) {
        console.error('Failed to parse JSON:', e);
      }
    } else {
      console.error('Request failed', this.status, this.responseText);
    }
  }
};

xmlhttp.open("POST", "https://remotehost.es/student014/shop/backend/endpoints/product_seller.php", true);
xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
//var body = "api_key=e888b918-330e-43c5-a103-111d57a4a28f";
xmlhttp.send();