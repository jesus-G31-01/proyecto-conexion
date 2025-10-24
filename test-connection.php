<?php
require_once 'config/database.php';

header('Content-Type: application/json');

try {
    $result = testDatabaseConnection();
    
    // Información adicional del servidor
    $result['server_info'] = [
        'php_version' => PHP_VERSION,
        'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'CLI',
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    echo json_encode($result, JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'server_info' => [
            'php_version' => PHP_VERSION,
            'timestamp' => date('Y-m-d H:i:s')
        ]
    ], JSON_PRETTY_PRINT);
}
?>