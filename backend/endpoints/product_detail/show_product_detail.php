<?php
session_start();

require $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect.php';

header('Content-Type: application/json');

if (!isset($conn) || !($conn instanceof mysqli)) {
    http_response_code(500);
    echo json_encode(['error' => 'DB connection not available']);
    exit;
}

$product_id = isset($_GET['productId']) ? intval($_GET['productId']) : 0;
if ($product_id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid product ID']);
    exit;
}

$sql = "SELECT p.product_id, p.name, p.price, p.long_description
        FROM `024_products` p
        WHERE p.product_id = $product_id
        LIMIT 1";

$result = mysqli_query($conn, $sql);
if ($result === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed', 'mysql_error' => mysqli_error($conn)]);
    exit;
}

$product = null;
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // available sizes
    $sizes_sql = "SELECT size FROM `024_product_sizes` WHERE product_id = $product_id";
    $sizes_result = mysqli_query($conn, $sizes_sql);
    $available_sizes = [];
    if ($sizes_result) {
        while ($size_row = mysqli_fetch_assoc($sizes_result)) {
            $available_sizes[] = $size_row['size'];
        }
    }

    // product materials (fixed select syntax)
    $materials_sql = "SELECT material_name, percentage FROM `024_product_materials` WHERE product_id = $product_id";
    $materials_result = mysqli_query($conn, $materials_sql);
    $materials = [];
    if ($materials_result) {
        while ($material_row = mysqli_fetch_assoc($materials_result)) {
            $materials[] = [
                'material_name' => $material_row['material_name'],
                'percentage' => $material_row['percentage']
            ];
        }
    }

    $product = [
        'product_id' => intval($row['product_id']),
        'product_name' => $row['name'],
        'price' => floatval($row['price']),
        'description' => $row['long_description'],
        'available_sizes' => $available_sizes,
        'materials' => $materials
    ];
}

echo json_encode($product);
exit;
