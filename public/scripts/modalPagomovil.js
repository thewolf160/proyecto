function abrirModalPagomovil(){
   const checkbox = document.getElementById('pago-movil');
    const modal = document.getElementById('modulo-pagomovil');
    if (checkbox.checked) {
        modal.showModal();
    } else {
        modal.close();
    }
}

function cerrarModalPagomovil() {
    document.getElementById('modulo-pagomovil').close();
    document.getElementById('pago-movil').checked = false;
}

document.querySelector('.metodo-pago').addEventListener('click', function() {
    abrirModalPagomovil();
});