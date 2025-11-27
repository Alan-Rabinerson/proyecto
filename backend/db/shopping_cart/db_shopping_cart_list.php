<?php
include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
$customer_id = $_SESSION['customer_id'];
$sql = "SELECT * FROM 024_shopping_cart WHERE customer_id = $customer_id";
$result = mysqli_query($conn, $sql);
$cart_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
$total_items = count($cart_items);
$cart_details = [];
$cart_total = 0;
$products = [];
if ($total_items > 0) {
    foreach ($cart_items as $item) {
        $product_id = $item['product_id'];
        $sql = "SELECT * FROM `024_products` WHERE product_id = $product_id";
        $product_result = mysqli_query($conn, $sql);
        $product = mysqli_fetch_assoc($product_result);
        $item['name'] = $product['name'];
        $item['price'] = $product['price'];
        $cart_details[] = $item;
        $product_id= $item['product_id'];
        $quantity = $item['quantity'];
        $products[] = ['product_id' => $product_id, 'quantity' => $quantity, 'price' => $item['price']];

        $item_total = $item['price'] * $item['quantity'];
        $cart_total += $item_total;

        // use size in container id to support multiple sizes for same product
        $size_safe = htmlspecialchars($item['size']);
        $container_id = 'product-' . $product_id . '-' . $size_safe;
        echo "<div class='product-card w-fit h-fit' id='" . $container_id . "'>";
        echo "<img src='/student024/shop/assets/imagenes/foto" . $product_id . ".jpg' alt='" . $item['name'] . "' class='w-48 h-48 object-cover mb-2 rounded-lg shadow-md'>";
        echo "<h3 id='product-name-" . $product_id . "'>" . $item['name']  ."</h3>";
        echo "<p id='product-price-" . $product_id . "'>Price: " . $item['price'] . "€ </p>";
        echo "<p>Size: " . htmlspecialchars($item['size']) . "</p>";
        echo "<p>Subtotal: " . ($item['price'] * $item['quantity']) . "€ </p>";
        echo "<span class='flex items-center gap-2'>";
        ?>
        <button onclick="removeQuantity(<?php echo $product_id; ?>, '<?php echo $item['size']; ?>', <?php echo $quantity; ?>, <?php echo $item['price']; ?>)"  class="boton-rojo rounded-4xl">-</button>           
        <?php echo "<p id='product-quantity-" . $product_id . "-" . htmlspecialchars($item['size']) . "'>Quantity: " . $item['quantity'] . "</p>";?>
        <button onclick="addQuantity(<?php echo $product_id; ?>, '<?php echo $item['size']; ?>', <?php echo $quantity; ?>, <?php echo $item['price']; ?>)" class="boton-rojo rounded-4xl">+</button>
        <?php
        echo "</span>";
        echo "</div><hr>";
    }
}else {
    echo "<p>Your shopping cart is empty.</p>";
}





?>