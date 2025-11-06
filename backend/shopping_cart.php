<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';
?>
<h2 class="text-2xl font-bold mb-4">Shopping Cart</h2>
<div>
    <?php
        if (empty($cart_items)) {
            echo "<p>Your shopping cart is empty.</p>";
        } else {
            ?>
            <div class="flex flex-wrap items-center justify-center">
                <?php
                    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/db/shopping_cart/db_shopping_cart_list.php';
                ?>
            </div>
        <?php
        }
    ?>
</div>
<?php
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';
?>
