<?php
    session_start();
    require_once __DIR__ . '/../../validators/validaciones.php';
    require_once __DIR__ . '/../../models/models_product/modelo_producto.php';

    $seccion = htmlspecialchars($_POST["seccion"] ?? null);
    $modeloProducto = new ModeloProducto();
    $controlador = new Controlador_Producto();

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        
        switch ($seccion) {
            case "agregar_producto":
                $agregado = $controlador->Agregar();
                $resultado = $controlador->CargarProductos("Todo");
                unset($_SESSION["usuario-root"]["Inventario"]);
                $_SESSION["usuario-root"]['Inventario'] = $resultado;
                header("Location: ./../../root/inventario.php");
                exit();
            break;

            case "modificar_producto":
                $actualizar = $controlador->ModificarProducto();
                $resultado = $controlador->CargarProductos("Todo");

                if(is_string($resultado)) {
                    unset($_SESSION["Error"]);
                    $_SESSION["Error"] = $actualizar;
                    header("Location: ./../../root/inventario.php");
                    exit();
                }
                    
                unset($_SESSION["usuario-root"]["Inventario"]);
                $_SESSION["usuario-root"]['Inventario'] = $resultado;
                header("Location: ./../../root/inventario.php");
                exit();
                
            break;

            case "Catalogo":
                $categoria = $_POST["categoria"] ?? null;
                $resultado = $controlador->CargarProductos($categoria);
                $_SESSION['Catalogo'] = [ 
                    "productos" => $resultado
                ];
                header("Location: ./../../views/catalogo.php"); 
                exit();
            break;

            case "BusquedaNombres":
                $tipoUsuario = htmlspecialchars($_POST["tipoUsuario"] ?? null);
                $resultado = $controlador->BuscarNombres($tipoUsuario);

                if(is_string($resultado)){
                    unset($_SESSION["Error"]);
                    $_SESSION['Error'] = $resultado;

                    if($tipoUsuario === "root") {
                        header("Location: ./../../root/inventario.php");
                    
                    } else { 
                        header("Location: ./../../views/catalogo.php");
                    }

                } else { 
                    if($tipoUsuario === "root") {
                        unset($_SESSION["usuario-root"]["Inventario"]);
                        $_SESSION["usuario-root"]["Inventario"] = $resultado;
                        header("Location: ./../../root/inventario.php");

                    } else {
                        unset($_SESSION["Catalogo"]["productos"]);
                        $_SESSION['Catalogo'] = ["productos" => $resultado];
                        header("Location: ./../../views/catalogo.php");
                    }
                }
                exit();
            break;

            case "Inventario":
                $resultado = $controlador->CargarProductos("Todo");
                unset($_SESSION["usuario-root"]["Inventario"]);
                $_SESSION['usuario-root']['Inventario'] = $resultado;
                header("Location: ./../../root/inventario.php");
                exit();
            break;

            case "EliminarProducto":
                $controlador->EliminarProducto();
                $resultado = $controlador->CargarProductos("Todo");
                unset($_SESSION["usuario-root"]["Inventario"]);
                $_SESSION["usuario-root"]['Inventario'] = $resultado;
                header("Location: ./../../root/inventario.php");  
                exit();
            break;
        }
    }


    /* CONTROLADOR DE PRODUCTOS */
    class Controlador_Producto {
        public function __construct(){}


        /* ESTA FUNCION ES PARA AGREGAR UN PRODUCTO */
        public function Agregar(){  // funciona
            global $modeloProducto;

            $resultado = $this->ValidarDatos();

            if(is_string($resultado)) return $resultado;

            $datosProducto = $resultado["datos"];
            $datosInventario = $resultado["datosInventario"];

            $resultado = $modeloProducto->M_ProductoAgregar($datosProducto, $datosInventario);
          
            return $resultado;
        }


        /* ESTA FUNCION ES PARA CARGAR LOS PRODUCTOS */ 
        public function CargarProductos($categoria){ // funciona
            global $modeloProducto;
            return $modeloProducto->ProductosConsultarTodos($categoria);
        }


        /* ESTA FUNCION ES PARA MODIFICAR UN PRODUCTO */
        public function ModificarProducto(){ // funciona
            global $modeloProducto;

            /* Datos nuevos */
            $DatosNuevos = $this->ValidarDatos();
    
            if(is_string($DatosNuevos)) return $DatosNuevos;

            $ProductoNuevo = $DatosNuevos["datos"];
            $InventarioNuevo = $DatosNuevos["datosInventario"];

            return $modeloProducto->ProductoModificar($ProductoNuevo, $InventarioNuevo);
        }


        public function BuscarNombres($tipoUsuario){
            global $modeloProducto;

            $nombre = htmlspecialchars($_POST["IBusqueda"] ?? null);

            if(DatosVacios(["nombre_producto" => $nombre])) return "Datos incompletos.";

            return $tipoUsuario !== "usuario-root" ? $modeloProducto->BuscarNombresUsuario($nombre) : $modeloProducto->BuscarNombresRoot($nombre);
        }


        /* ESTA FUNCION ES PARA ELIMINAR UN PRODUCTO */
        public function EliminarProducto(){ // funciona
            global $modeloProducto;
            $codigo = htmlspecialchars($_POST["codigo"] ?? null);
            $datos = ["codigo" => $codigo];

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

            $datosInventario =[ "stock" => $stock ];

            if (DatosVacios($datosInventario)) return "Faltan campos por completar.";
            if(NumeroInvalido($datosInventario["stock"])) return "Valor Invalido. El stock no puede ser un números negativo.";
            
            return ["datos" => $datos, "datosInventario" => $datosInventario];
        }
    }
?>
