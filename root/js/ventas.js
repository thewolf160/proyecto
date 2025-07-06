document.addEventListener('DOMContentLoaded', function() {
    
    // Función para agrupar compras
    function agruparCompras(compras) {
        const comprasAgrupadas = {};
        
        compras.forEach(compra => {
            if (!comprasAgrupadas[compra.compra_id]) {
                comprasAgrupadas[compra.compra_id] = {
                    compra_id: compra.compra_id,
                    fecha_compra: compra.fecha_compra || 'Fecha no disponible',
                    total_compra: parseFloat(compra.total_compra) || 0,
                    estado: compra.estado || 'Pendiente',
                    metodo_pago: compra.metodo_pago || 'No especificado',
                    nombre_usuario: compra.nombre_usuario || 'Cliente no identificado',
                    usuario_id: compra.usuario_id || 'N/A',
                    correo: compra.correo || 'No especificado',
                    productos: []
                };
            }
            
            // Agregar producto solo si existe la información
            if (compra.nombre_producto) {
                comprasAgrupadas[compra.compra_id].productos.push({
                    nombre_producto: compra.nombre_producto,
                    codigo_producto: compra.codigo_producto || 'N/A',
                    cantidad: parseInt(compra.cantidad) || 0,
                    precio_unitario: parseFloat(compra.precio_unitario) || 0,
                    subtotal_detalle: parseFloat(compra.subtotal_detalle) || 0
                });
            }
        });
        
        return Object.values(comprasAgrupadas);
    }

    // Función para renderizar compras
    function renderizarCompras(compras) {
      
        const container = document.getElementById('compras-container');
        
        if (!compras || compras.length === 0) {
            container.innerHTML = '<h1>No hay ventas registradas</h1>';
            return;
        }
    
        try {
            const comprasAgrupadas = agruparCompras(compras);
            let html = '';
            
            comprasAgrupadas.forEach(compra => {
                let estadoClass = 'estado-badge estado-pendiente';
                if (compra.estado.toLowerCase().includes('complet')) estadoClass = 'estado-badge estado-completado';
                if (compra.estado.toLowerCase().includes('cancel')) estadoClass = 'estado-badge estado-cancelado';
                
                html += `
                <section class="compra-section">
                    <div class="compra-header">
                        <h3>
                            Compra #${compra.compra_id}
                            <span class="${estadoClass}">${compra.estado}</span>
                        </h3>
                    </div>
                    
                    <div class="compra-info">
                        <div>
                            <p><span>Fecha:</span> <span>${compra.fecha_compra}</span></p>
                            <p><span>Total:</span> <span>$${compra.total_compra.toFixed(2)}</span></p>
                        </div>
                        <div>
                            <p><span>Método:</span> <span>${compra.metodo_pago}</span></p>
                            <p><span>Cliente:</span> <span>${compra.nombre_usuario}</span></p>
                        </div>
                    </div>
                    
                    <div class="productos-scroll-container">
                        <h4>Productos (${compra.productos.length})</h4>
                        ${compra.productos.map(producto => `
                            <div class="producto-item">
                                <p><span>Producto:</span> <span>${producto.nombre_producto}</span></p>
                                <p><span>Cantidad:</span> <span>${producto.cantidad}</span></p>
                                <p><span>P. Unitario:</span> <span>$${producto.precio_unitario.toFixed(2)}</span></p>
                                <p><span>Subtotal:</span> <span>$${producto.subtotal_detalle.toFixed(2)}</span></p>
                            </div>
                        `).join('')}
                    </div>
                </section>
                `;
            });
            
            container.innerHTML = html;
        } catch (error) {
            console.error('Error al renderizar compras:', error);
            container.innerHTML = '<h1 class="error">Error al cargar las ventas</h1>';
        }
    }
    // Iniciar la visualización
    renderizarCompras(comprasData);
});