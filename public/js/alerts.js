'use strict'

var notification = (title, icono, message) => {

    const operation = {
        'Success': 'Correcto',
        'Info': 'Información',
        'Error': 'Error',
    };

    if (message) {
        $.toast({
            heading: operation[title],
            text: message,
            showHideTransition: 'slide',
            icon: icono,
            allowToastClose: true,
            position: 'top-right',
            hideAfter: 10000
        });
    }
    else {
        $.toast({
            heading: operation[title],
            text: 'Lo siento, no cuentas con los permisos necesarios para realizar esta acción.',
            showHideTransition: 'slide',
            icon: icono,
            allowToastClose: true,
            position: 'top-right',
            hideAfter: 10000
        });
    }
};