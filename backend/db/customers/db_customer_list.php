<?php
    include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/config/db_connect.php';

    $sql = "SELECT * FROM 024_customers";
    $result = mysqli_query($conn, $sql);
    $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach($customers as $customer){
        $customer_id = $customer['customer_id'];
        echo "<div>";
        echo "<h3>" . $customer['first_name'] . " " . $customer['last_name'] . "</h3>";
        echo "<p>Email: " . $customer['email'] . "</p>";
        echo "<p>Phone: " . $customer['phone'] . "</p>";
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/customers/form_customer_update_call.php';
        include $_SERVER['DOCUMENT_ROOT'].'/student024/shop/backend/forms/customers/form_customer_delete.php';
        echo "</div><hr>";
    }

?>