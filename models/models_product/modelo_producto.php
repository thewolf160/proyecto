<?php
    require_once __DIR__ . '/../operaciones.php';
    require_once __DIR__ . '/../models_inventory/modelo_inventario.php';

    $operaciones = new Operaciones("localhost", "root", "", "pincos");
    $modeloInventario = new ModeloInventario();

    class ModeloProducto {

        public function __construct(){}

        /* ESTA FUNCION ES PARA AGREGAR UN PRODUCTO */
        public function M_ProductoAgregar($datos, $datosInventario){
            global $operaciones;
            global $modeloInventario;

            $Existencia = ["codigo" => $datos["codigo"] ];

            if($operaciones->Consultar("productos", $Existencia) !== null) return "Ya existe un producto con ese codigo";
            
            $resultado = $operaciones->Agregar("productos", $datos);

            if($resultado === true){
                $Producto = $operaciones->Consultar("productos", ["codigo" => $datos["codigo"]]);
                $datosInventario["producto_id"] = $Producto["id"];
                return $modeloInventario->M_InventarioAgregar($datosInventario);  
            
            } else {
                return "Error al agregar producto";
            }
        }


        /* ESTA FUNCION ES PARA CARGAR LOS PRODUCTOS */
        public function ProductosConsultarTodos($categoria){
            global $operaciones;

            if($categoria === "Todo"){
                $consulta = "
                    SELECT * 
                    FROM productos p 
                    INNER JOIN inventario i ON p.id = i.producto_id 
                    WHERE i.stock > 0 AND p.activo = 1
                ";
            } else {
                $consulta = "
                    SELECT * FROM productos p 
                    INNER JOIN inventario i ON p.id = i.producto_id 
                    WHERE p.categoria = '$categoria' AND i.stock > 0 AND p.activo = 1
                ";
            }

            return $operaciones->ObtenerTodos($consulta);
        }

        /* ESTA FUNCION ES PARA MODIFICAR UN PRODUCTO */
        public function ProductoModificar($datosProducto, $datosInventario){
            global $operaciones;
            global $modeloInventario;

            $Existencia = [];

            if(isset($datos["codigo"])){
                $Existencia["codigo"] = $datos["codigo"];

                if($operaciones->Consultar("productos", ["codigo" => $datos["codigo"]]) !== null){
                    return "ERROR: Ya existe un producto con ese codigo";
                }
            }
            $resultado = $operaciones->Modificar("productos", $datosProducto);

            !$resultado || $resultado === null ? "ERROR: No se pudo modificar el producto" : $modeloInventario->M_InventarioModificar($datosInventario);
        }

        public function M_ProductoEliminnar($datos){
            global $operaciones;
            global $modeloInventario;
        
            $resultado = $operaciones->Modificar("productos", $datos);

            if($resultado === null || !$resultado){
                return "ERROR: No se pudo eliminar el producto.";

            }  else {
                $inventario = $operaciones->Consultar("inventario", ["producto_id" => $datos["id"]]);

                if($inventario !== null){
                    $modificacionInventario = [
                        "id" => $inventario["id"],
                        "stock" => "0",
                        "stock_maximo" => "0",
                        "stock_minimo" => "0"
                    ];
                    return $modeloInventario->M_InventarioEliminar($modificacionInventario);
                }
            }
        }
    }
?>