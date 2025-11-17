<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';
    $cart_total = 0.0;
    $total_items = 0;
?>
<h2 class="text-2xl font-bold mb-4 text-center">Shopping Cart</h2>
<div class="text-center">
   
    <div class="flex flex-wrap items-center justify-center gap-4" id="cart-items">
        <?php require $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/db/shopping_cart/db_shopping_cart_list.php'; ?>
    </div>
        
    <h3>Total Items:
        <?php echo $total_items; ?>
    </h3>
    <h3>Cart Total:
        <?php echo number_format($cart_total, 2). "€"; ?>
    </h3>
</div>
<?php
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';
?>
