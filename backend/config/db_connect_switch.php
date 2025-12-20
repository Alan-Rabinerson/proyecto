<?php
// DB connection switcher: includes local or remote DB config based on current host
// Usage: include $_SERVER['DOCUMENT_ROOT'].'/student024/Shop/backend/config/db_connect_switch.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$serverHost = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? '');
$docRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
$basePath = '/student024/Shop/backend/config/';
$localConfig = $docRoot . $basePath . 'db_connect.php';
$remoteConfig = $docRoot . $basePath . 'db_connect_remotehost.php';

$isLocal = in_array($serverHost, ['localhost', '127.0.0.1']) || preg_match('/\.local$/i', $serverHost);
$isRemoteHost = stripos($serverHost, 'remotehost.es') !== false;

try {
    if ($isLocal && file_exists($localConfig)) {
        include $localConfig;
    } elseif ($isRemoteHost && file_exists($remoteConfig)) {
        include $remoteConfig;
    } else {
        // Fallback: prefer remote, then local
        if (file_exists($remoteConfig)) {
            include $remoteConfig;
        } elseif (file_exists($localConfig)) {
            include $localConfig;
        } else {
            throw new Exception('No se encontraron archivos de configuración de BD.');
        }
    }

    if (!isset($conn) || !($conn instanceof mysqli)) {
        throw new Exception('La conexión de base de datos no se inicializó correctamente para host: ' . $serverHost);
    }
} catch (Exception $e) {
    // Emitir un error JSON claro si se usa en endpoints
    if (!headers_sent()) {
        header('Content-Type: application/json', true, 500);
    }
    echo json_encode([
        'error' => 'Error de configuración de base de datos: ' . $e->getMessage(),
        'host' => $serverHost
    ]);
    exit;
}
