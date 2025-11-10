<?php 
function searchProduct($conn, $searchTerm) {
    $searchTerm = mysqli_real_escape_string($conn, $searchTerm);
    $sql = "SELECT * FROM 024_products WHERE name LIKE '%$searchTerm' OR description LIKE '%$searchTerm'";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        die("Database query failed: " . mysqli_error($conn));
    }

    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $products;
}
?>