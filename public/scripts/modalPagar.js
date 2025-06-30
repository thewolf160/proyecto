function abrirModalPagar(){
    document.getElementById("seccion-pagar").showModal();
}

function cerrarModalPagar(){
    document.getElementById("seccion-pagar").close();
}

// Función para cerrar el modal de pago móvil y volver al principal si quieres
function cerrarModalPagomovil() {
    const modal = document.getElementById('modulo-pagomovil');
    modal.close();
    document.getElementById('pago-movil').checked = false;
    // Si quieres volver al modal principal, descomenta la siguiente línea:
    document.getElementById('seccion-pagar').showModal();
}

// Función para cerrar el modal de otros métodos
function cerrarModalOtros() {
    const modal = document.getElementById('modulo-otros');
    modal.close();
    // Desmarca los otros checkboxes si quieres
    document.getElementById('punto-venta').checked = false;
    document.getElementById('efectivo').checked = false;
    document.getElementById('credito').checked = false;
    // Si quieres volver al modal principal, descomenta la siguiente línea:
    document.getElementById('seccion-pagar').showModal();
}

document.addEventListener('DOMContentLoaded', function() {
    const btnAceptar = document.querySelector('#botones-pago button');
    btnAceptar.addEventListener('click', function() {
        const pagoMovil = document.getElementById('pago-movil');
        const puntoVenta = document.getElementById('punto-venta');
        const efectivo = document.getElementById('efectivo');
        const credito = document.getElementById('credito');

        // Cierra todos los modales antes de abrir el siguiente
        document.getElementById('seccion-pagar').close();
        document.getElementById('modulo-pagomovil').close();
        document.getElementById('modulo-otros').close();

        if (pagoMovil.checked) {
            document.getElementById('modulo-pagomovil').showModal();
        } else if (puntoVenta.checked || efectivo.checked || credito.checked) {
            document.getElementById('modulo-otros').showModal();
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // ...tu código existente para btnAceptar...

    // Solución: desmarcar el checkbox cuando el modal se cierra de cualquier forma
    document.getElementById('modulo-pagomovil').addEventListener('close', function() {
        document.getElementById('pago-movil').checked = false;
    });
});