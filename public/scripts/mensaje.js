/* document.getElementById('formulario_registro').addEventListener('submit', function(e) {
    e.preventDefault(); // 👈 Evita que recargue la página

    const formData = new FormData(this);
    formData.append("seccion", "Registrarse"); // 👈 Importante para el switch PHP

    fetch('comunicacion.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('ErroresRegistro').textContent = data.error;

        if (data.exito) {
            // Redirigir si todo fue bien
            window.location.href = '../views/registro.html';
        }
    })
    .catch(error => {
        document.getElementById('ErroresRegistro').textContent = "Error de red: ";;
    });
});
*/
