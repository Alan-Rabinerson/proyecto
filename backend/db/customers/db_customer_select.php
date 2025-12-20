<?php include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/header.php'; 
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';// Llama al script para obtener los productos

    // verify if product_id is set and is numeric
    if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])){
        $product_id = intval($_GET['product_id']);

        // query to obtain product data
        $sql = "SELECT * FROM 024_customers WHERE customer_id = $customer_id";
        $result = mysqli_query($conn, $sql);
        $customer = mysqli_fetch_assoc($result);

        print_r($customer); // Muestra los datos del cliente para verificar

    } else if (empty($_GET['customer_id'])) { // if customer_id is not set, show all customers
        $sql = "SELECT * FROM 024_customers";
        $result = mysqli_query($conn, $sql);
        $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);

        foreach ($customers as $customer) {
            echo "<div class='card mb-3'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>".$customer['first_name']."</h5>";
            echo "<p class='card-text'>Last Name: ".$customer['last_name']."</p>";
            echo "<p class='card-text'>Email: ".$customer['email']."</p>";
            echo "<p class='card-text'>Username: ".$customer['username']."</p>";
            echo "<p class='card-text'>Password: ".$customer['password']."</p>";
            echo "<p class='card-text'>Phone: ".$customer['phone']."</p>";
            echo "<p class='card-text'>Birth Date: ".$customer['birth_date']."</p>";
            echo "</div>";
            echo "</div>";
        }
        
    }else { // if product_id is not numeric, show error
        echo "<div class='alert alert-danger mt-4'>Invalid product ID.</div>";
    }
    include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/footer.php'; 
?>
