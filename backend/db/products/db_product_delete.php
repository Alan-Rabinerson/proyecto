    <?php
        include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect.php';
        // get data
        $productId = $_POST['product_id'];
        // delete sizes, stock, categories associations first due to foreign key constraints
        $sql_sizes = "DELETE FROM `024_product_sizes` WHERE product_id=$productId";
        if (!mysqli_query($conn, $sql_sizes)) {
            header("Location: /student024/Shop/backend/views/products.php?error=Error+deleting+product+$productId+:+".$conn->error);
            exit();
        }
        $sql_categories = "DELETE FROM `024_product_category` WHERE product_id=$productId";
        if (!mysqli_query($conn, $sql_categories)) {
            header("Location: /student024/Shop/backend/views/products.php?error=Error+deleting+product+$productId+:+".$conn->error);
            exit();
        }
        
        // sql to delete From 024_products
        $sql = "DELETE FROM `024_products` WHERE product_id=$productId";
        // send confirmation or error message
        if ( mysqli_query($conn, $sql) === TRUE) {
           header("Location: /student024/Shop/backend/views/products.php?success=Product+$productId+deleted+successfully");
        } else {
            header("Location: /student024/Shop/backend/views/products.php?error=Error+deleting+product+$productId+:+".$conn->error);
        }
    ?>
