<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';
?>
<h2 class="text-2xl font-bold mb-4 text-center">Shopping Cart</h2>
<div class="text-center">
   
    <div class="flex flex-wrap items-center justify-center gap-4">
        <?php
            include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/db/shopping_cart/db_shopping_cart_list.php';
        ?>
    </div>
        
    <h3>Total Items:
        <?php echo $total_items; ?>
    </h3>
    <h3 id="cart-total">Cart Total:
        <?php echo number_format($cart_total, 2). "€"; ?>
    </h3>
    <form action="" method="post">
        <input type="submit" class="boton-rojo rounded-4xl mb-4" value="Proceed to Checkout">
    </form>
</div>
<script src="/student024/shop/JavaScript/shopping_cart.js"></script>
<?php
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';
?>
