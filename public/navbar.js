document.addEventListener("DOMContentLoaded", () =>{
            fetch("navbar.html")
            .then(response => response.text())
            .then(data => {
                document.getElementById("navbar").innerHTML = data;
            })
            .catch(error => console.error("Error al cargar barra de navegacion: ", error));
        }
    );
