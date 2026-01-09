<?php
    function write_logJSON($message, $type, $category, $log) {
        $log_file = $_SERVER['DOCUMENT_ROOT'] . "/student024/Shop/backend/logs/" . $log;
        $connection_log = fopen($log_file, 'a');
        $timestamp = date('Y-m-d H:i:s');
        $log_entry = [
            'timestamp' => $timestamp,
            'type' => $type,
            'category' => $category,
            'message' => $message
        ];
        fwrite($connection_log, json_encode($log_entry) . PHP_EOL);
        fclose($connection_log);
    }