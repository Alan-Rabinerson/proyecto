<?php
    function showCustomer($customer) {
        // Display customer information in a card format
        $customer_id = $customer['customer_id'];
        echo  "<div class='customer-card w-fit h-fit border-azul-claro p-4 rounded-lg shadow-md flex flex-col items-center' id='customer-" . $customer_id . "'>" .
        "<img src='/student024/Shop/assets/avatars/avatar.png' class='w-24 h-24 object-cover mb-2 rounded-lg shadow-md '>" .
        "<h3>" . $customer['first_name']  . " " . $customer['last_name'] ."</h3>".
        "<p>Email: " . $customer['email'] . "</p>".
        "<p>Phone: " . $customer['phone'] . "</p>";
        include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/forms/customers/form_customer_update_call.php';
        include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/forms/customers/form_customer_delete.php';
        echo "</div>";
    }
?>