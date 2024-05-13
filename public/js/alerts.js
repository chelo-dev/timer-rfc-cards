'use strict'

var notification = (title, icono, message) => {

    const operation = {
        'Success': 'Success',
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
            text: 'Lo siento pero tenemos problemas con el servidor, por favor espere un momento y si el problema persiste comuniquese con soporte tecnico.',
            showHideTransition: 'slide',
            icon: icono,
            allowToastClose: true,
            position: 'top-right',
            hideAfter: 10000
        });
    }
};