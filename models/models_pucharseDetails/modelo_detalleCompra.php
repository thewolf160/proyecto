<?php
    require_once __DIR__ . '/../operaciones.php';
    require_once __DIR__ . '/../models_inventory/modelo_inventario.php';

    $operaciones = new Operaciones("localhost", "root", "", "pincos");
    $modelo_inventario = new ModeloInventario();

    class ModeloDetallesCompra{
        public function __construct(){}

        
        /* ESTA FUNCION ES PARA AGREGAR DETALLES DE COMPRA */
        public function AgregarDetallesCompra($datos){
            global $operaciones;
            global $modelo_inventario;

            foreach($datos as $Detalle) { 
                $resultado = $operaciones->Agregar("detalles_compras", $Detalle); 
                $inventario = $modelo_inventario->M_InventarioConsultar(["producto_id" => $Detalle["producto_id"]]);
                
                $inventario["stock"] = $inventario["stock"] - $Detalle["cantidad"];

                $modelo_inventario->M_InventarioModificar($inventario, "");
            }
            return $resultado;
        }


        /* ESTA FUNCION ES PARA OBTENER TODOS LOS DETALLES DE COMPRA */
        public function M_NostrarCompras(){
            global $operaciones;
            global $modelo_inventario;

            $consulta = "SELECT 
                c.id AS compra_id,
                c.fecha_compra,
                c.total AS total_compra,
                c.estado,
                c.metodo_pago,
                
                u.id AS usuario_id,
                u.nombre AS nombre_usuario,
                u.identificacion,
                u.direccion AS direccion_usuario,
                u.correo,
                
                dc.id AS detalle_id,
                dc.cantidad,
                dc.precio_unitario,
                dc.subtotal AS subtotal_detalle,
                
                p.id AS producto_id,
                p.codigo AS codigo_producto,
                p.nombre_producto,
                p.descripcion AS descripcion_producto,
                p.precio AS precio_actual_producto,
                p.categoria
            FROM 
                compras c
            INNER JOIN 
                detalles_compras dc ON c.id = dc.compra_id
            INNER JOIN 
                usuarios u ON c.usuario_id = u.id
            INNER JOIN 
                productos p ON dc.producto_id = p.id
            ORDER BY 
                c.fecha_compra DESC, c.id, dc.id;";

            $resultado = $operaciones->ObtenerTodos($consulta);

            foreach($resultado as $unidad){
                if($unidad["estado"] === "pendiente"){
                    $fechaActual = new DateTime();
                    $fechaRegistro = new DateTime($unidad["fecha_compra"]);
                    $diferencia = $fechaActual->diff($fechaRegistro);

                    if($diferencia->days >= 10){
                        $obj = $modelo_inventario->M_InventarioConsultar(["id" => $unidad["inventario_id"]]);

                        $obj["stock"] = $obj["stock"] + $unidad["cantidad"];

                        $modelo_inventario->M_InventarioModificar($obj, "");
                        $operaciones->Eliminar("compras", ["id" => $unidad["compra_id"]]);
                    }
                }
            }
            return $operaciones->ObtenerTodos($consulta);
        }


        /* ESTA FUNCION ES PARA ELIMINAR UN DETALLE DE COMPRA */
        public function ELiminarCompra($id){
            global $operaciones;
            return $operaciones->Eliminar("compras", ["id" => $id]);
        }


        /* ESTA FUNCION ES PARA CONSULTAR UN DETALLE DE COMPRA */
        public function M_ConsultarDetalles($parametro){
            global $operaciones;
            return $operaciones->Consultar("detalles_compras", $parametro);
        }
    }
?>