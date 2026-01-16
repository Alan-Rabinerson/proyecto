<?php
// Guarda los datos del clima en un archivo
function saveWeatherToFile($weather) {
    $file = $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/db/weather/weather_log.json';
    $data = [
        'temperature' => $weather['Temperature']['Metric']['Value'] ?? null,
        'description' => $weather['WeatherText'] ?? '',
        'icon' => $weather['WeatherIcon'] ?? 0,
        'recorded_at' => date('Y-m-d H:i:s')
    ];
    $json = json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($file, $json . "\n", FILE_APPEND);
}
?>
