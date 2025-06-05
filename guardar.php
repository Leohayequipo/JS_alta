<?php
header('Content-Type: application/json');

// Conectar a la base de datos
try {
    $pdo = new PDO('mysql:host=localhost;dbname=dbform;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al conectar con la base de datos']);
    exit;
}

// Leer JSON recibido
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if ($data === null) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'JSON inválido']);
    exit;
}

// Validar campos obligatorios
$required = ['nombre', 'email', 'telefono', 'edad', 'comentario'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => "Falta el campo: $field"]);
        exit;
    }
}

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email inválido']);
    exit;
}

$edad = filter_var($data['edad'], FILTER_VALIDATE_INT);
if ($edad === false) {
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
    echo json_encode(['success' => true, 'message' => 'Datos guardados correctamente']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al guardar los datos']);
}
