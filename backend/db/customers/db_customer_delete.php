<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/header.php';// header no terminado ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';// Llama al script para obtener los productos
    // capturar datos del producto a actualizar
    $customer_id = $_GET['id'];
    // delete product data in database
    $sql = "DELETE FROM 024_customers WHERE customer_id = $customer_id";
    if (mysqli_query($conn, $sql)) {
        echo "<p>Customer ID $customer_id deleted successfully.</p>";
    } else {
        echo "<p>Error deleting customer: " . mysqli_error($conn) . "</p>";
    }

    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/footer.php';// footer no terminado
?>