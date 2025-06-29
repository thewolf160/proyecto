document.addEventListener("DOMContentLoaded", () => {
    fetch("../views/navbar2.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("navbar").innerHTML = data;

            // Ahora sí puedes seleccionar y agregar el evento
            const botonUsuario = document.getElementById("usuarioBoton");
            const menuUsuario = document.getElementById("menu-usuario");

            botonUsuario.addEventListener("click", () => {
                menuUsuario.classList.toggle("hidden");
            });
        })
        .catch(error => console.error("Error al cargar barra de navegacion: ", error));
});



