<?php
// Configuración para MySQL en Azure - USA VARIABLES DE ENTORNO
function getDatabaseConfig() {
    // Leer variables de entorno del App Service
    $host = getenv('DB_HOST') ?: 'mysql-server-1.mysql.database.azure.com';
    $port = getenv('DB_PORT') ?: '3306';
    $dbname = getenv('DB_NAME') ?: 'mysql-server-1';
    $username = getenv('DB_USER') ?: 'jesus123@mysql-server-1';
    $password = getenv('DB_PASS') ?: 'contraseña123456@@';
    
    return [
        'host' => $host,
        'port' => $port,
        'dbname' => $dbname,
        'username' => $username,
        'password' => $password,
        'ssl' => true
    ];
}

// Opciones para PDO
$db_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// Cadena de conexión
function getConnectionString() {
    $config = getDatabaseConfig();
    $ssl_options = $config['ssl'] ? ";ssl_mode=REQUIRED" : '';
    
    return "mysql:host=" . $config['host'] . ";port=" . $config['port'] . ";dbname=" . $config['dbname'] . ";charset=utf8mb4" . $ssl_options;
}

// Función para probar conexión
function testDatabaseConnection() {
    try {
        $config = getDatabaseConfig();
        $connection = new PDO(getConnectionString(), $config['username'], $config['password'], $GLOBALS['db_options']);
        
        // Verificar versión de MySQL
        $version = $connection->query('SELECT VERSION()')->fetchColumn();
        
        return [
            'status' => 'success',
            'message' => '✅ Conexión exitosa a MySQL en Azure',
            'version' => $version,
            'host' => $config['host'],
            'database' => $config['dbname'],
            'user' => $config['username'],
            'source' => 'App Service Environment Variables'
        ];
        
    } catch (PDOException $e) {
        $config = getDatabaseConfig();
        return [
            'status' => 'error',
            'message' => '❌ Error de conexión: ' . $e->getMessage(),
            'code' => $e->getCode(),
            'host_attempted' => $config['host'],
            'user_attempted' => $config['username'],
            'source' => 'App Service Environment Variables'
        ];
    }
}

// Función debug para ver qué variables se están usando
function debugDatabaseConfig() {
    $config = getDatabaseConfig();
    $env_host = getenv('DB_HOST');
    
    return [
        'DB_HOST_env' => $env_host,
        'DB_HOST_used' => $config['host'],
        'DB_NAME_env' => getenv('DB_NAME'),
        'DB_NAME_used' => $config['dbname'],
        'DB_USER_env' => getenv('DB_USER'),
        'DB_USER_used' => $config['username'],
        'DB_PASS_env' => getenv('DB_PASS') ? '***' : 'not set',
        'all_env_vars' => $_SERVER
    ];
}
?>