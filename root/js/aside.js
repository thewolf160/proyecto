document.addEventListener("DOMContentLoaded", () =>{
            fetch("../root/html/aside.html")
            .then(response => response.text())
            .then(data => {
                document.getElementById("aside").innerHTML = data;
            })
            .catch(error => console.error("Error al cargar barra de navegacion: ", error));
        }
    );

const enlaceCSS = document.createElement("link");
enlaceCSS.rel = "stylesheet";
enlaceCSS.href = "aside.css";
document.head.appendChild(enlaceCSS);