<?php
// public/health.php - Railway Health Check
header('Content-Type: application/json');
http_response_code(200);

echo json_encode([
    'status' => 'healthy',
    'timestamp' => date('Y-m-d H:i:s'),
    'service' => 'Pengaduan Masyarakat Laravel',
    'endpoint' => '/health.php',
    'php_version' => phpversion()
]);
