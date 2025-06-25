<?php
// Configuración DB
$host = 'localhost';
$db = 'test_tecnica_contacto';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error al conectar con la base de datos: " . $e->getMessage()
    ]);
    exit;
}

echo json_encode(["success" => true, "message" => "Conexión exitosa"]);

?>