<?php
// Configuración para MySQL en Azure
// ⚠️ REEMPLAZA ESTOS DATOS CON LOS TUYOS ⚠️
define('DB_HOST', 'tu-servidor-mysql.mysql.database.azure.com');
define('DB_PORT', '3306');
define('DB_NAME', 'nombre_base_datos');
define('DB_USER', 'tu_usuario@tu-servidor-mysql');
define('DB_PASS', 'tu_contraseña');
define('DB_SSL', true);

// Opciones para PDO
$db_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// Cadena de conexión
function getConnectionString() {
    $ssl_options = '';
    if (DB_SSL) {
        $ssl_options = ";ssl_mode=REQUIRED";
    }
    
    return "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4" . $ssl_options;
}

// Función para probar conexión
function testDatabaseConnection() {
    try {
        $connection = new PDO(getConnectionString(), DB_USER, DB_PASS, $GLOBALS['db_options']);
        
        // Verificar versión de MySQL
        $version = $connection->query('SELECT VERSION()')->fetchColumn();
        
        return [
            'status' => 'success',
            'message' => '✅ Conexión exitosa a MySQL en Azure',
            'version' => $version,
            'host' => DB_HOST,
            'database' => DB_NAME
        ];
        
    } catch (PDOException $e) {
        return [
            'status' => 'error',
            'message' => '❌ Error de conexión: ' . $e->getMessage(),
            'code' => $e->getCode()
        ];
    }
}
?>