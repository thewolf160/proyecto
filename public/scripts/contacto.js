function Validacion() {
    event.preventDefault();
    const formulario = document.getElementById('formulario-contacto');
    let esValido = true;

    // Guardar placeholders originales
    const placeholders = {
        nombre: document.getElementById('nombre').placeholder,
        apellido: document.getElementById('apellido').placeholder,
        correo: document.getElementById('correo').placeholder,
        mensaje: document.getElementById('mensaje').placeholder
    };

    // Función para marcar errores en placeholder
    function marcarError(campo, mensaje) {
        const input = document.getElementById(campo);
        input.placeholder = mensaje;
        input.classList.add('campo-error');
        input.value = ''; // Limpiar el valor
        esValido = false;
    }

    // Resetear campos
    function resetearCampo(campo) {
        const input = document.getElementById(campo);
        input.classList.remove('campo-error');
        input.placeholder = placeholders[campo];
    }

    // Resetear todos los campos primero
    Object.keys(placeholders).forEach(resetearCampo);

    // Validar campos
    if (!document.getElementById('nombre').value.trim()) {
        marcarError('nombre', 'Por favor ingresa tu nombre');
    }

    if (!document.getElementById('apellido').value.trim()) {
        marcarError('apellido', 'Por favor ingresa tu apellido');
    }

    if (!document.getElementById('correo').value.trim()) {
        marcarError('correo', 'Por favor ingresa tu correo electrónico');
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(document.getElementById('correo').value)) {
        marcarError('correo', 'Por favor ingresa un correo válido');
    }

    if (!document.getElementById('mensaje').value.trim()) {
        marcarError('mensaje', 'Por favor ingresa tu mensaje');
    }

    // Si todo es válido, mostrar modal y enviar
    if (esValido) {
        const modalExito = document.getElementById('modal-exito');
        if (modalExito) {
            // Mostrar el diálogo (método nativo del dialog)
            modalExito.showModal();  // Esto es lo que cambia
            
            document.getElementById('btn-aceptar').onclick = function() {
                // Cerrar el diálogo
                modalExito.close();  // Método nativo para cerrar
                formulario.submit();
            };
        } else {
            formulario.submit();
        }
    }
}