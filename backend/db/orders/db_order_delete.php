<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/header.php';// header no terminado ?> 
<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';

    $order_number = $_GET['order_number'];

    $sql = "DELETE FROM 024_orders_table WHERE order_number = $order_number";
    $result = mysqli_query($conn, $sql);
    if($result){
        echo "Pedido eliminado correctamente.";
    } else {
        echo "Error al eliminar el pedido: " . mysqli_error($conn);
    }
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/includes/footer.php';// footer no terminado
?>