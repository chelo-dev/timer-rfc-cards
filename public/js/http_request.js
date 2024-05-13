function submitForm(event) {
    event.preventDefault();

    const form = document.getElementById('sendForm');
    httpService(form);
}

function httpService(form) {
    const formData = new FormData(form);
    const url = form.action;

    fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': formData.get('_token'),
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#account-form-edit').modal('hide');
                notification('Success', 'success', data.message);
            } else {
                notification('Error', 'error', data.message);
            }
        })
        .catch(error => {
            notification('Error', 'error', 'Error intenta una vez mas.');
        });
}

async function fetchData(url, method = 'GET', body = null) {
    // Configuración de los encabezados
    const headers = {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken, // Usa la variable del token aquí
        'Accept': 'application/json'
    };

    // Opciones de la solicitud
    const options = {
        method,
        headers
    };

    // Agregar el cuerpo solo si es un método que lo requiere (POST o PUT generalmente)
    if (method === 'POST' || method === 'PUT') {
        options.body = JSON.stringify(body);
    }

    // Realizar la solicitud
    try {
        const response = await fetch(url, options);
        // Manejo de errores si el estado no es OK (status code 200-299)
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        // Parsear la respuesta a JSON
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Error:', error.message);
        // Manejo de errores adicional
        return { error: error.message };
    }
}

