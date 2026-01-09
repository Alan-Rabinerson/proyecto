<?php
    function write_logJSON($message, $type, $category, $log) {
        $log_file = $_SERVER['DOCUMENT_ROOT'] . "/student024/Shop/backend/logs/" . $log;
        $timestamp = date('Y-m-d H:i:s');
        $log_entry = [
            'timestamp' => $timestamp,
            'type' => $type,
            'category' => $category,
            'message' => $message
        ];
        
        // Si el archivo no existe o está vacío, inicializar array vacío
        if (!file_exists($log_file) || filesize($log_file) == 0) {
            $entries = [];
        } else {
            // Leer el contenido existente y decodificarlo
            $content = file_get_contents($log_file);
            $entries = json_decode($content, true) ?? [];
        }
        
        // Agregar la nueva entrada al array
        $entries[] = $log_entry;
        
        // Escribir el array completo de vuelta al archivo
        file_put_contents($log_file, json_encode($entries));
    }