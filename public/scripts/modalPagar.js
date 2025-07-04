function abrirModalPagar(){
    document.getElementById("seccion-pagar").showModal();
}

function cerrarModalPagar(){
    document.getElementById("seccion-pagar").close();
}


function cerrarModalPagomovil() {
    const modal = document.getElementById('modulo-pagomovil');
    modal.close();
    document.getElementById('pago-movil').checked = false;
    
    document.getElementById('seccion-pagar').showModal();
}


function cerrarModalOtros() {
    const modal = document.getElementById('modulo-otros');
    modal.close();
    
    document.getElementById('punto-venta').checked = false;
    document.getElementById('efectivo').checked = false;
    document.getElementById('credito').checked = false;
  
    document.getElementById('seccion-pagar').showModal();
}

document.addEventListener('DOMContentLoaded', function() {
    const btnAceptar = document.querySelector('#botones-pago button');
    btnAceptar.addEventListener('click', function() {
        const pagoMovil = document.getElementById('pago-movil');
        const puntoVenta = document.getElementById('punto-venta');
        const efectivo = document.getElementById('efectivo');
        const credito = document.getElementById('credito');

        
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

    document.getElementById('modulo-pagomovil').addEventListener('close', function() {
        document.getElementById('pago-movil').checked = false;
    });
});