# JS_alta

Pasos para ejecutar el proyecto de ejemplo y probar el formulario.

## 1. Crear la base de datos

1. Cree una base de datos MySQL (por ejemplo `contactos_db`).
2. Ejecute el script `create_table.sql` en esa base. Puede hacerlo con la línea de comandos:

```bash
mysql -u <usuario> -p contactos_db < create_table.sql
```

Esto creará la tabla `contactos`.

## 2. Configurar `guardar.php`

Coloque un archivo `guardar.php` en el mismo directorio que `index.php` y `script.js`.
Este archivo debe conectar con la base de datos y guardar los datos recibidos en la tabla `contactos`.
Un ejemplo mínimo de configuración es:

```php
<?php
$conexion = new mysqli('localhost', 'usuario', 'contraseña', 'contactos_db');

$datos = json_decode(file_get_contents('php://input'), true);
$stmt = $conexion->prepare('INSERT INTO contactos(nombre, email, telefono, edad, comentario) VALUES (?,?,?,?,?)');
$stmt->bind_param('sssis', $datos['nombre'], $datos['email'], $datos['telefono'], $datos['edad'], $datos['comentario']);
$stmt->execute();

echo json_encode(['message' => 'Datos guardados']);
?>
```

Ajuste las credenciales según su entorno.

## 3. Levantar un servidor PHP local

Para probar el formulario abra una terminal en este directorio y ejecute:

```bash
php -S localhost:8000
```

Luego acceda a `http://localhost:8000/index.php` desde el navegador y complete el formulario.
