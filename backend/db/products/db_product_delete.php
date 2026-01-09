    <?php
        include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';
        include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/write_logJSON.php';
        session_start();
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
            if ($_SESSION['role'] == 'admin') {
                write_logJSON("Product with ID " . $productId . " deleted by customer " . $_SESSION['customer_id'] ." ". $_SESSION['username'], "delete", "product", "changes_log.json");
            }
           header("Location: /student024/Shop/backend/views/products.php?success=Product+$productId+deleted+successfully");
        } else {
            header("Location: /student024/Shop/backend/views/products.php?error=Error+deleting+product+$productId+:+".$conn->error);
        }
    ?>
