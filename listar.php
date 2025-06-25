<?php
header('Content-Type: application/json');
require 'conexion.php';

try {
    $stmt = $pdo->query('SELECT nombre, email, telefono, edad, comentario FROM contactos ORDER BY creado_en DESC');
    $contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode([
        'success' => true,
        'contactos' => $contactos
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener los contactos: ' . $e->getMessage()
    ]);
} 