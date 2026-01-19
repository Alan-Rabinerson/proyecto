<?php

// Endpoint para recibir datos de clima (current conditions + 3day forecast)
// Guarda en archivo JSON, inserta en la base de datos y muestra por pantalla

include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/write_log.php';
include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/functions/write_logJSON.php';

// Leer entrada cruda
$raw_input = file_get_contents('php://input');
$headers = function_exists('getallheaders') ? getallheaders() : [];
$decoded = null;
if (!empty($raw_input)) {
    $decoded = json_decode($raw_input, true);
}

// Detectar si el archivo se está ejecutando directamente o se está incluyendo
$is_direct = realpath(__FILE__) === realpath($_SERVER['SCRIPT_FILENAME']);

// Si no hay entrada POST y estamos incluidos (por ejemplo en el footer),
// cargar la última entrada guardada para mostrar el clima en la plantilla
if (empty($raw_input) && !$is_direct) {
    $logPath = __DIR__ . '/../../logs/weather_entries.json';
    if (file_exists($logPath)) {
        $logContent = file_get_contents($logPath);
        $entries = json_decode($logContent, true);
        if (is_array($entries) && count($entries) > 0) {
            $last = end($entries);
            $message = isset($last['message']) ? $last['message'] : null;
            if ($message) {
                $entryData = json_decode($message, true);
                if ($entryData) {
                    $current = $entryData['currentConditions'] ?? [];
                    $forecast = $entryData['threeDayForecast'] ?? [];
                }
            }
        }
    }
    // No continuar con el resto del procesamiento que asume una petición POST
} else {
    // Guardar debug del request
    write_log('Received weather POST', 'weather_debug.log');
    write_logJSON($raw_input, 'info', 'weather_raw', 'weather_debug.json');

    if ($decoded !== null) {
        // Soportar dos formatos comunes:
        // 1) {"currentConditions": [...], "threeDayForecast": [...]}
        // 2) Un array con current conditions como primer elemento y forecast separado
        $current = [];
        $forecast = [];

        if (isset($decoded['currentConditions'])) {
            $current = $decoded['currentConditions'];
        }
        elseif (isset($decoded[0]) && is_array($decoded[0]) && isset($decoded[0]['LocalObservationDateTime'])) {
            $current = $decoded; // payload de current conditions directamente
        }

        if (isset($decoded['threeDayForecast'])) {
            $forecast = $decoded['threeDayForecast'];
        }

        // Construir entrada unificada
        $entry = [
            'recorded_at' => date('Y-m-d H:i:s'),
            'remote_addr' => $_SERVER['REMOTE_ADDR'] ?? '',
            'headers' => $headers,
            'currentConditions' => $current,
            'threeDayForecast' => $forecast
        ];

        // Guardar en fichero JSON (append como array usando write_logJSON)
        write_logJSON(json_encode($entry), 'info', 'weather_entry', 'weather_entries.json');

        // También añadir una entrada simple en el log de texto
        write_log('Weather entry saved at ' . $entry['recorded_at'], 'weather_debug.log');

        // Insertar en la base de datos. Reutilizamos db_connect.php (variable $conn)
        if (isset($conn) && $conn) {
            $payload = mysqli_real_escape_string($conn, json_encode(['currentConditions'=>$current,'threeDayForecast'=>$forecast]));
            $recorded_at = mysqli_real_escape_string($conn, $entry['recorded_at']);
            $sql = "INSERT INTO 024_weather_data (date_time, cc_info_JSON) VALUES ('" . $recorded_at . "', '" . $payload . "')";
            $res = mysqli_query($conn, $sql);
            if (!$res) {
                write_log('DB insert failed: ' . mysqli_error($conn), 'weather_debug.log');
            }
        }
        // Si la petición fue directa (no inclusión), devolver JSON para que el cliente pueda parsearlo
        if ($is_direct) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'ok',
                'recorded_at' => $entry['recorded_at'],
                'currentCount' => is_array($current) ? count($current) : 0
            ]);
            // Asegurar que no se envía más contenido
            exit;
        }
    }
}

