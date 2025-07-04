<?php
    session_start();
    require_once __DIR__ . '/../../validators/validaciones.php';
    require_once __DIR__ . '/../../models/models_product/modelo_producto.php';

    $seccion = htmlspecialchars($_POST["seccion"] ?? null);
    $modeloProducto = new ModeloProducto();
    $controlador = new Controlador_Producto();

    $cargar = $controlador->CargarProductos("Todo");

    foreach ($cargar as $fila) {
        print_r($fila); echo "<br><br>";// Muestra cada fila como array asociativo
    }

    switch ($seccion) {
        case "agregar_producto":
            $resultado = $controlador->Agregar();
            unset($_SESSION['productos']);
            $_SESSION['resultado'] = $resultado;
            // header("Location: ../views/agregarProducto.html");
            exit();
        break;

        case "modificar_producto":
            $resultado = $controlador->ModificarProducto($datos, $datosNuevos);

            if(isset($resultado["error"])){
                echo $resultado["error"];
                
             } else {
                return $resultado;
            }
        break;

        case "Catalogo":
            $categoria = $_POST["categoria"] ?? null;
            $resultado = $controlador->CargarProductos($categoria);
            unset($_SESSION['productos']);
            $_SESSION['productos'] = $resultado;
            //header("Location: ./../../views/catalogo.php"); Asi debe ir la ruta
            exit();
        break;

        case "BusquedaNombres":
            $resultado = $controlador->BuscarNombres();
            
            if(is_string($resultado)) {
                echo $resultado;
            } else {
                foreach($resultado as $fila){
                    echo $fila["nombre_producto"] . "<br>";
                    echo $fila["stock"] . "<br>";

                }
            }
        break;
    }



    /* CONTROLADOR DE PRODUCTOS */
    class Controlador_Producto {
        public function __construct(){}


        /* ESTA FUNCION ES PARA AGREGAR UN PRODUCTO */
        public function Agregar(){  // funciona
            global $modeloProducto;

            $resutado = $this->ValidarDatos();

            $datosProducto = $resutado["datos"];
            $datosInventario = $resutado["datosInventario"];

            $resultado = $modeloProducto->M_ProductoAgregar($datosProducto, $datosInventario);
          
            return $resultado;
        }


        /* ESTA FUNCION ES PARA CARGAR LOS PRODUCTOS */ 
        public function CargarProductos($categoria){ // funciona
            global $modeloProducto;
            return $modeloProducto->ProductosConsultarTodos($categoria);
        }


        /* ESTA FUNCION ES PARA MODIFICAR UN PRODUCTO */
        public function ModificarProducto($datosViejos){ // funciona
            global $modeloProducto;

            /* Datos nuevos */
            $DatosNuevos = $this->ValidarDatos();
            $ProductoNuevo = $DatosNuevos["datos"];
            $InventarioNuevo = $DatosNuevos["datosInventario"];

            /* Datos actuales */
            $ProductoActual = [
                "id" => $datosViejos["producto_id"],
                "nombre_producto" => $datosViejos["nombre_producto"],
                "codigo" => $datosViejos["codigo"],
                "descripcion" => $datosViejos["descripcion"],
                "precio" => $datosViejos["precio"],
                "categoria" => $datosViejos["categoria"],
            ];
            $InventarioActual = [
                "id" => $datosViejos["id"],
                "stock" => $datosViejos["stock"],
                "stock_maximo" => $datosViejos["stock_maximo"],
                "stock_minimo" => $datosViejos["stock_minimo"],
            ];


            $idProducto = $ProductoActual["id"];
            $idInventario = $InventarioActual["id"];

            unset($InventarioActual["id"]);
            unset($ProductoActual["id"]);

            $InventarioFinal = ExtraerIguales($InventarioActual, $InventarioNuevo);
            $ProductoFinal = ExtraerIguales($ProductoActual, $ProductoNuevo);

            $ProductoFinal["id"] = $idProducto;
            $InventarioFinal["id"] = $idInventario;

            return $modeloProducto->ProductoModificar($ProductoFinal, $InventarioFinal);
        }


        public function BuscarNombres(){
            global $modeloProducto;

            $nombre = htmlspecialchars($_POST["IBusqueda"] ?? null);
            $tipoUsuario = htmlspecialchars($_POST["tipoUsuario"] ?? null);

            if(DatosVacios(["nombre_producto" => $nombre])) return "Datos incompletos.";

            return $tipoUsuario !== "usuario-root" ? $modeloProducto->BuscarNombresUsuario($nombre) : $modeloProducto->BuscarNombresRoot($nombre);
        }


        /* ESTA FUNCION ES PARA ELIMINAR UN PRODUCTO */
        public function EliminarProducto(){ // funciona
            global $modeloProducto;
            $id = htmlspecialchars($_POST["id"] ?? null);
            $datos = ["id" => $id, "activo" => "0"];

            return $modeloProducto->M_ProductoEliminnar($datos);
        }
    

        /* ESTA FUNCION RECIBE LOS VALORES DE LOS PRODUCTOS */
        private function ValidarDatos(){
            $nombre = htmlspecialchars($_POST["INombreProducto"] ?? null);
            $codigo = htmlspecialchars($_POST["ICodigo"] ?? null);
            $descripcion = htmlspecialchars($_POST["IDescripcion"] ?? null);
            $precio = htmlspecialchars($_POST["IPrecio"] ?? null);
            $categoria = htmlspecialchars($_POST["ICategoria"] ?? null);
            $stock = htmlspecialchars($_POST["IStock"] ?? null);
            $stockMax = htmlspecialchars($_POST["IStockMax"] ?? null);
            $stockMin = htmlspecialchars($_POST["IStockMin"] ?? null);

            $datos = [
                "nombre_producto" => $nombre,
                "codigo" => $codigo,
                "descripcion" => $descripcion,
                "precio" => (double)$precio,
                "categoria" => $categoria,
            ];

            if (DatosVacios($datos)) {
                return "Faltan campos por completar.";
            } else if(NombreInvalido($datos["nombre_producto"])){
                return "Nombre Invalido";
            }else if (NumeroInvalido($datos["precio"])) {
                return "Precio Invalido. No pueden ser números negativos.";
            } 

            $datosInventario =[
                "stock" => $stock,
                "stock_maximo" => $stockMax,
                "stock_minimo" => $stockMin
            ];

            if (DatosVacios($datosInventario)) return "Faltan campos por completar.";

            foreach($datosInventario as $clave => $valor){
                if(NumeroInvalido($valor)){
                    return "Valor Invalido. El stock no puede ser un números negativo.";
                }
            }
            return ["datos" => $datos, "datosInventario" => $datosInventario];
        }
    }
?>
