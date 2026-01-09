<?php    
    function write_log($message, $log) {
        $log_file = $_SERVER['DOCUMENT_ROOT'] . "/student024/Shop/backend/logs/" . $log;;
        $connection_log = fopen($log_file, 'a');
        $timestamp = date('Y-m-d H:i:s');
        fwrite($connection_log, "[$timestamp] $message" . PHP_EOL);
    }
    

