<?php
header('Content-Type: application/json');
ob_start(); // Inicia el buffer de salida

require 'conexion.php'; // Usa la conexión centralizada

// Leer JSON recibido
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if ($data === null) {
    ob_end_clean();
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'JSON inválido']);
    exit;
}

// Validar campos obligatorios
$required = ['nombre', 'email', 'telefono', 'edad', 'comentario'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        ob_end_clean();
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => "Falta el campo: $field"]);
        exit;
    }
}

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    ob_end_clean();
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email inválido']);
    exit;
}

$edad = filter_var($data['edad'], FILTER_VALIDATE_INT);
if ($edad === false) {
    ob_end_clean();
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Edad inválida']);
    exit;
}

// Guardar en la base de datos
try {
    $stmt = $pdo->prepare('INSERT INTO contactos (nombre, email, telefono, edad, comentario) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([
        $data['nombre'],
        $data['email'],
        $data['telefono'],
        $edad,
        $data['comentario']
    ]);
    ob_end_clean();
    echo json_encode(['success' => true, 'message' => 'Datos guardados correctamente']);
} catch (PDOException $e) {
    ob_end_clean();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al guardar los datos: ' . $e->getMessage()]);
}
