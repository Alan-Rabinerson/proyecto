<?php
require $_SERVER['DOCUMENT_ROOT'] . '/backend/config/db_connect_switch.php';
$api_key = 'e888b918-330e-43c5-a103-111d57a4a28f'; 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['api_key'] === $api_key) {
    correctKey();
} else {
    wrongKey();
}

function correctKey() {
    $sql = "SELECT * FROM 024_products WHERE supplier_id = 1 LIMIT 5";
    $result = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($products);
}

function wrongKey() {
    http_response_code(403);
    echo json_encode(array("message" => "Forbidden: Invalid API Key"));
}
?>
