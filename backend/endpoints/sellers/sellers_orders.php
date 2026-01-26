<?php 
    require $_SERVER['DOCUMENT_ROOT'] . '/backend/config/db_connect_switch.php';
    $api_key = 'e888b918-330e-43c5-a103-111d57a4a28f'; 
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['api_key'] === $api_key) {
        correctKey();
    } else {
        wrongKey();
    }
    function correctKey() {
        global $conn;
        $products = json_decode($_POST['products'], true);
        $order_date = date('Y-m-d H:i:s');
        $customer = json_decode($_POST['customer'], true);
        


    }
    function wrongKey() {
        http_response_code(403);
        echo json_encode(array("message" => "Forbidden: Invalid API Key"));
    }