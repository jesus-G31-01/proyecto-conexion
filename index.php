<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificador de Conexión MySQL - Azure</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>🔍 Verificador de Conexión MySQL</h1>
        <h2>Azure Database for MySQL</h2>
        
        <?php
        // Incluir configuración de base de datos
        require_once 'config/database.php';
        
        // Probar la conexión
        $connectionResult = testDatabaseConnection();
        ?>
        
        <div class="status-card <?php echo $connectionResult['status'] === 'success' ? 'status-success' : 'status-error'; ?>">
            <div class="status-icon">
                <?php echo $connectionResult['status'] === 'success' ? '✅' : '❌'; ?>
            </div>
            <div class="status-message">
                <?php echo $connectionResult['message']; ?>
            </div>
            
            <?php if ($connectionResult['status'] === 'success'): ?>
                <div class="details">
                    <div class="detail-item">
                        <strong>Servidor:</strong> <?php echo htmlspecialchars($connectionResult['host']); ?>
                    </div>
                    <div class="detail-item">
                        <strong>Base de Datos:</strong> <?php echo htmlspecialchars($connectionResult['database']); ?>
                    </div>
                    <div class="detail-item">
                        <strong>Versión MySQL:</strong> <?php echo htmlspecialchars($connectionResult['version']); ?>
                    </div>
                    <div class="detail-item">
                        <strong>Estado:</strong> <span style="color: green;">● Conectado</span>
                    </div>
                </div>
            <?php else: ?>
                <div class="details">
                    <div class="detail-item">
                        <strong>Código de Error:</strong> <?php echo $connectionResult['code']; ?>
                    </div>
                    <div class="detail-item">
                        <strong>Servidor:</strong> <?php echo htmlspecialchars(DB_HOST); ?>
                    </div>
                    <div class="detail-item">
                        <strong>Usuario:</strong> <?php echo htmlspecialchars(DB_USER); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div style="text-align: center;">
            <button class="btn" onclick="location.reload()">🔄 Probar Nuevamente</button>
            <a href="test-connection.php" class="btn" style="background: #28a745;">📊 Ver JSON</a>
        </div>
        
        <!-- Información de configuración -->
        <div class="config-info">
            <h3>⚙️ Configuración Actual:</h3>
            <div class="detail-item">
                <strong>Host:</strong> <?php echo DB_HOST; ?>
            </div>
            <div class="detail-item">
                <strong>Usuario:</strong> <?php echo DB_USER; ?>
            </div>
            <div class="detail-item">
                <strong>Base de Datos:</strong> <?php echo DB_NAME; ?>
            </div>
            <div class="detail-item">
                <strong>SSL:</strong> <?php echo DB_SSL ? 'Habilitado' : 'Deshabilitado'; ?>
            </div>
        </div>
    </div>
</body>
</html>