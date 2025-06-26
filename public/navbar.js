document.addEventListener("DOMContentLoaded", () =>{
            fetch("../views/navbar.html")
            .then(response => response.text())
            .then(data => {
                document.getElementById("navbar").innerHTML = data;
            })
            .catch(error => console.error("Error al cargar barra de navegacion: ", error));
        }
    );

const enlaceCSS = document.createElement("link");
enlaceCSS.rel = "stylesheet";
enlaceCSS.href = "../public/navbar.css";
document.head.appendChild(enlaceCSS);
