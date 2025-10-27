<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/header.php';// header no terminado ?>
    <?php
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
        // get data
        $productId = $_GET['productId'];
        // sql to delete a record
        $sql = "DELETE FROM `024_products` WHERE product_id=$productId";
        // send confirmation or error message
        if ( mysqli_query($conn, $sql) === TRUE) {
            echo "<main><h2 class='mt-4'>Product deleted successfully</h2>";
            echo "<p>Product ID: $productId</p></main>";
        } else {
            echo "<main><h2 class='mt-4'>Error deleting product: " . mysqli_error($conn) . "</h2></main>";
        }
    ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/footer.php';// footer no terminado ?>