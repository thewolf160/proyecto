<?php
    /* ENLACES ENTRE ARCHIVOS */
    require_once __DIR__ . '/../operaciones.php';

    /* OBJETO DE LAS OPERACIONES */
    $operaciones = new Operaciones("localhost", "root", "", "pincos");

    class ModeloUsuario {
        public function __construct(){}

    
        /* ESTA FUNCION ES PARA AGREGAR UN USUARIO */
        public function M_UsuarioAgregar($datos){
            global $operaciones;

            $Existencia = [
                "identificacion" => $datos["identificacion"],
                "correo" => $datos["correo"]
            ];

            foreach ($Existencia as $columna => $valor) {
                $resultado = $operaciones->Consultar("usuarios", [$columna => $valor]);
                
                if(empty($resultado)) { return "Error al agregar usuario."; }
            }
            return $operaciones->Agregar("usuarios", $datos) ? "Usuario agregado." : "Error al agregar usuario.";
        }


        /* ESTA FUNCION ES PARA INICIAR SESIÓN */
        public function M_UsuarioIniciarSesion($datos){
            global $operaciones;

            $contraseña = $datos["clave"];
            unset($datos["clave"]);

            $resultado = $operaciones->Consultar("usuarios", $datos);
            $datos["clave"] = $contraseña;

            if(empty($resultado)) { return "Error al consultar usuario.";}
            
            if (password_verify($datos["clave"], $resultado["clave"])) {
                return $resultado;
            } else {
                return "Contraseña incorrecta";
            }
        }


        /* ESTA FUNCION ES PARA ACTUALIZAR UN USUARIO */
        public function M_UsuarioActualizar($datos){
            global $operaciones;
            $Existencia = [];

            if(isset($datos["correo"])) $Existencia["correo"] = $datos["correo"];

            if(isset($datos["identificacion"])) $Existencia["identificacion"] = $datos["identificacion"];
            
            if(!empty($Existencia)){
                foreach ($Existencia as $columna => $valor) {
                    if (($operaciones->Consultar("usuarios", [$columna => $valor])) !== null) {
                        return "Ya existe $columna con el valor que estas ingresando.";
                    }
                }   
            }

            $resultado =$operaciones->Modificar("usuarios", $datos);
            return empty($resultado) ? "Error al actualizar usuario." : $resultado;
        }


        /* ESTA FUNCION ES PARA ELIMINAR UN USUARIO */
        public function M_UsuarioEliminar($datos){
            global $operaciones;
            $resultado = $operaciones->Modificar("usuarios", $datos);
            return empty($resultado) ? "ERROR: No se pudo eliminar el usuario." : "Usuario eliminado correctamente.";
        }


        /* ESTA FUNCION ES PARA OBTENER TODOS LOS USUARIOS */
        public function M_UsuarioObtenerTodos(){
            global $operaciones;
            $consulta = "SELECT * FROM usuarios WHERE activo = 1";
            return $operaciones->ObtenerTodos($consulta);
        }


        /* ESTA FUNCION ES PARA BUSCAR USUARIOS */
        public function M_UsuarioBusqueda($busqueda){
            global $operaciones;
            $consulta = "SELECT * FROM usuarios WHERE activo = 1 AND (nombre LIKE '%$busqueda%' OR  identificacion LIKE '%$busqueda%')";
            $resultado = $operaciones->ObtenerTodos($consulta);
            return empty($resultado) ? "Usuario no encontrado" : $resultado;
        }
    }
?>