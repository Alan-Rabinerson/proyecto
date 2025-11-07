<?php
    $new_quantity = $item['quantity'] + 1;
?>
<form action="/student024/shop/backend/db/shopping_cart/db_shopping_cart_product_update.php" method="POST" class="">
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" hidden>
    <input type="number" name="quantity" value="<?php echo $new_quantity; ?>" min="1" hidden>
    <button class="boton-rojo rounded-4xl" type="submit">+</button>
</form>