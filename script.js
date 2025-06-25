document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contactoForm');

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const nombre = document.getElementById('nombre').value.trim();
        const email = document.getElementById('email').value.trim();
        const telefono = document.getElementById('telefono').value.trim();
        const edadValor = document.getElementById('edad').value.trim();
        const comentario = document.getElementById('comentario').value.trim();

        // Validación
        if (!nombre || !email || !telefono || !edadValor || !comentario) {
            alert('Por favor, completa todos los campos.');
            return;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Ingresa un email válido.');
            return;
        }

        const edadNumero = parseInt(edadValor);
        if (Number.isNaN(edadNumero)) {
            alert('Ingresa una edad válida.');
            return;
        }

        const datos = {
            nombre,
            email,
            telefono,
            edad: edadNumero,
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
        .then(async response => {
            let result;
            try {
                result = await response.json();
            } catch (e) {
                throw new Error('Respuesta no válida del servidor');
            }

            if (!response.ok || !result.success) {
                throw new Error(result && result.message ? result.message : 'Error desconocido');
            }

            alert(result.message);
        })
        .catch(error => {
            console.error('Error al enviar:', error);
            alert(error.message || 'Hubo un error al enviar los datos.');
        });
    });
});
