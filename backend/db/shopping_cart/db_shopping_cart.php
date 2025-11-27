<?php 
    session_start();
    header('Content-Type: application/json; charset=utf-8');
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';
    $customer_id = $_SESSION['customer_id'] ?? 0;
    $product_id = $_GET['product_id'] ?? 0;
    $size = isset($_GET['size']) ? $conn->real_escape_string($_GET['size']) : '';
    $action = $_GET['action'] ?? '';
    $quantity = $_GET['quantity'] ?? 0;
    $new_quantity = 0;

    if ($action == 'add'){
        $new_quantity = $quantity + 1;
    } elseif ($action == 'remove' && $quantity > 1){
        $new_quantity = $quantity - 1;
    }
    
    if ($new_quantity == 0){
        if ($size !== '') {
            $query = "DELETE FROM 024_shopping_cart WHERE customer_id = $customer_id AND product_id = $product_id AND size = '$size'";
        } else {
            $query = "DELETE FROM 024_shopping_cart WHERE customer_id = $customer_id AND product_id = $product_id";
        }
        $result = mysqli_query($conn, $query);
    } else {
        if ($size !== '') {
            $query = "UPDATE 024_shopping_cart SET `quantity` = $new_quantity WHERE customer_id = $customer_id AND product_id = $product_id AND size = '$size'";
        } else {
            $query = "UPDATE 024_shopping_cart SET `quantity` = $new_quantity WHERE customer_id = $customer_id AND product_id = $product_id";
        }
        $result = mysqli_query($conn, $query);
    }

    if ($result){
        if ($size !== '') {
            $sql = "SELECT * FROM 024_shopping_cart WHERE customer_id = $customer_id AND product_id = $product_id AND size = '$size'";
        } else {
            $sql = "SELECT * FROM 024_shopping_cart WHERE customer_id = $customer_id AND product_id = $product_id";
        }
        $result2 = mysqli_query($conn, $sql);
        $products = mysqli_fetch_all($result2, MYSQLI_ASSOC);
        if (is_array($products) && count($products) > 0) {
            // return structured response with the updated item
            echo json_encode(['status' => 'ok', 'item' => $products[0]]);
        } else {
            // item was deleted
            echo json_encode(['status' => 'deleted', 'item' => null]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    }
?>