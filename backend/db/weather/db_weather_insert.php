<?php
// Guarda los datos del clima en la tabla weather_data
include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect.php';

function insertWeather($weather) {
    global $conn;
    $recorded_at = date('Y-m-d H:i:s');
    $sql = "INSERT INTO 024_weather_data (date_time, cc_info_JSON) VALUES ($recorded_at, '" . mysqli_real_escape_string($conn, json_encode($weather)) . "')";
    $query = mysqli_query($conn, $sql);
    

        
}
?>
