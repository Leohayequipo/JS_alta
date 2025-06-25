<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Contacto</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 1em;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
        tr:nth-child(even) {
            background: #fafafa;
        }
        .no-contactos {
            color: #888;
            margin-top: 1em;
        }
    </style>
</head>
<body>
    <h1>Formulario de Contacto</h1>

    <form id="contactoForm">
        <input type="text" id="nombre" placeholder="Nombre"><br><br>
        <input type="email" id="email" placeholder="Email"><br><br>
        <input type="tel" id="telefono" placeholder="Teléfono"><br><br>
        <input type="number" id="edad" placeholder="Edad"><br><br>
        <textarea id="comentario" placeholder="Comentario"></textarea><br><br>
        <button type="submit">Enviar</button>
    </form>

    <h2>Contactos guardados</h2>
    <div id="listaContactos">Cargando...</div>

    <script src="script.js"></script>
    <script>
    function cargarContactos() {
        fetch('listar.php')
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (data.contactos.length === 0) {
                        document.getElementById('listaContactos').innerHTML = '<div class="no-contactos">No hay contactos.</div>';
                        return;
                    }
                    let html = `<table><thead><tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Edad</th>
                        <th>Comentario</th>
                    </tr></thead><tbody>`;
                    data.contactos.forEach(c => {
                        html += `<tr>
                            <td>${c.nombre}</td>
                            <td>${c.email}</td>
                            <td>${c.telefono}</td>
                            <td>${c.edad}</td>
                            <td>${c.comentario}</td>
                        </tr>`;
                    });
                    html += '</tbody></table>';
                    document.getElementById('listaContactos').innerHTML = html;
                } else {
                    document.getElementById('listaContactos').innerText = data.message || 'Error al cargar contactos';
                }
            })
            .catch(() => {
                document.getElementById('listaContactos').innerText = 'Error al cargar contactos';
            });
    }
    cargarContactos();
    // Opcional: recargar lista tras enviar el formulario
    document.getElementById('contactoForm').addEventListener('submit', function() {
        setTimeout(cargarContactos, 500);
    });
    </script>
</body>
</html>
