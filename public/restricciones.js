function configurarZoomInicial() {
    document.body.style.zoom = "100%";
    document.body.style.transform = "scale(1)";
    document.body.style.transformOrigin = "0 0";
    document.documentElement.style.touchAction = "pan-x pan-y";
}

function desactivarZoom() {
    document.addEventListener('keydown', (evento) => {
        if (evento.ctrlKey && ['+', '-', '0'].includes(evento.key)) {
            evento.preventDefault();
            configurarZoomInicial(); // Reforzar el zoom al 100%
        }
    });

    document.addEventListener('wheel', (evento) => {
        if (evento.ctrlKey) {
            evento.preventDefault();
            configurarZoomInicial();
        }
    }, { passive: false });

    document.addEventListener('gesturestart', (evento) => {
        evento.preventDefault();
    });

    // 4. Bloquear zoom con pellizco (pinch-to-zoom)
    document.addEventListener('touchmove', (evento) => {
        if (evento.scale !== 1) {
            evento.preventDefault();
        }
    }, { passive: false });
}

document.addEventListener('DOMContentLoaded', () => {
    configurarZoomInicial();
    desactivarZoom();
});

window.addEventListener('load', () => {
    configurarZoomInicial();
});