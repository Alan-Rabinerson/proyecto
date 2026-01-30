<?php
include $_SERVER['DOCUMENT_ROOT'] . '/student024/Shop/backend/config/db_connect_switch.php';
include $_SERVER['DOCUMENT_ROOT'] . '/student024/Shop/backend/functions/write_logJSON.php';
curl_setopt($ch, CURLOPT_URL, "https://remotehost.es/student024/Shop/APIs/other_shop/teamwear.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
$result = curl_exec($ch);
curl_close($ch);
$products= json_decode($result, true);
$sql = "SELECT * FROM `024_products` WHERE supplier_id = 2";
$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query) == 0) {
    // solo insertar si no hay productos de este proveedor
    foreach ($products as $product) {
        $sql = "INSERT INTO `024_products` (product_name, description, long_description, price, supplier_id, product_code, image_url, available_sizes) VALUES ($product[product_name], $product[product_name], $product[product_name], $product[product_unit_price], 2, $product[product_id]), $product[product_image], 'S,M,L,XL,XXL')";
        if (mysqli_query($conn, $sql)) {
            write_logJSON("New record created successfully for supplier Teamwear with product code " . $product['product_id'], "insert", "products", "changes_log.json");
        } else {
            write_logJSON("Error creating record for product: " . $product['product_name'] . " - " . mysqli_error($conn), "insert", "products", "changes_log.json");
            $message = urlencode("Error creating record for product: " . $product['product_name']);
            header("Location: /student024/Shop/backend/views/products.php?error=$message");
        }
    }
    header('Location: /student024/Shop/backend/views/products.php?message=' . urlencode('Products from Teamwear supplier inserted successfully.'));
}
?>
