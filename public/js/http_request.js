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
