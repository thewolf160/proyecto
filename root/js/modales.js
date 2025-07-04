function abrirModalAgregar(){
    document.getElementById("seccion-agregar").showModal();
}

function cerrarModalAgregar(){
    document.getElementById("seccion-agregar").close();
}

function abrirModalEliminar(){
    document.getElementById("seccion-eliminar").showModal();
}

function cerrarModalEliminar(){
    document.getElementById("seccion-eliminar").close();
}

document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('imagen');
    const nombre = document.getElementById('nombre-imagen');
    if(input && nombre) {
        input.addEventListener('change', function() {
            nombre.textContent = this.files.length > 0 ? this.files[0].name : 'Ningún archivo seleccionado';
        });
    }
});
