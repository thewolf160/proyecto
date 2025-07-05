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

function abrirModalActualizar(){
    document.getElementById("seccion-actualizar").showModal();
}

function cerrarModalActualizar(){
    document.getElementById("seccion-actualizar").close();
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
