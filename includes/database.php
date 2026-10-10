<?php

// Errores de MySQL como excepciones (igual que el valor por defecto desde PHP 8.1)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $db = mysqli_connect(
    $_ENV['DB_HOST'], 
    $_ENV['DB_USER'], 
    $_ENV['DB_PASS'],
    $_ENV['DB_BD']);
} catch (mysqli_sql_exception $e) {
    // El detalle va al log del servidor; en pantalla no se muestran datos de la conexión
    error_log('No se pudo conectar a MySQL: ' . $e->getMessage());
    http_response_code(500);
    echo "No se pudo conectar a la base de datos. Intenta de nuevo en unos minutos.";
    exit;
}
