document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contactoForm');

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const nombre = document.getElementById('nombre').value.trim();
        const email = document.getElementById('email').value.trim();
        const telefono = document.getElementById('telefono').value.trim();
        const edad = document.getElementById('edad').value.trim();
        const comentario = document.getElementById('comentario').value.trim();

        // Validación
        if (!nombre || !email || !telefono || !edad || !comentario) {
            alert('Por favor, completa todos los campos.');
            return;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Ingresa un email válido.');
            return;
        }

        const datos = {
            nombre,
            email,
            telefono,
            edad: parseInt(edad),
            comentario
        };

        console.log('Datos listos para enviar:', datos);

        fetch('guardar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datos)
        })
        .then(response => response.json())
        .then(result => {
            console.log('Respuesta del backend:', result);
            alert(result.message);
        })
        .catch(error => {
            console.error('Error al enviar:', error);
            alert('Hubo un error al enviar los datos.');
        });
    });
});
