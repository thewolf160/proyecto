<?php
    session_start();

    require_once __DIR__ . '/../../validators/validaciones.php';
    require_once __DIR__ . '/../../models/models_user/modelo_usuario.php';

    $seccion = htmlspecialchars($_POST["seccion"] ?? null);
    $modeloUsuario = new ModeloUsuario();
    $controlador = new Usuario_Controlador();

    $cargar = $modeloUsuario->M_UsuarioObtenerTodos();

    foreach ($cargar as $fila) {
        print_r($fila); echo "<br><br>";// Muestra cada fila como array asociativo
    }

    switch ($seccion) {
        case "Registrarse":
            $resultado = $controlador->Agregar();
            unset($_SESSION["resultado"]);
            $_SESSION["resultado"] = $resultado;
            header("location: ./../../views/registro.php");
            exit();
        break;

        case "inicio_sesion":
            $resultado = $controlador->inicioSesion();
            
            if($resultado === null || is_string($resultado)){
                unset($_SESSION["resultado"]);
                $_SESSION["resultado"] = $resultado;
                header("location: ./../../views/inicio_sesion.php");
                exit();
            }

            if ($resultado["nombre"] === "root"){
                unset($_SESSION["usuario-root"]);
                $_SESSION["usuario-root"] = $resultado;
                header("location: ./../../views/inicio.php");
                exit();
            } 

            unset($_SESSION["usuario"]);
            $_SESSION["usuario"] = $resultado;
            header("location: ./../../views/inicio.php");
            exit();
        break;

        case "CerrarSesion":
            session_destroy();
            header("location: ./../../views/inicio.php");
            exit();
        break;

        case "ActualizarUsuario":
            $resultado = $controlador->ActualizarUsuario($usuarioIniciado, $modificacion);

            if(isset($resultado["exito"])){
                $resultado["error"];
                
             } else {
                $resultado;
            } 
           
        break;
    }

    class Usuario_Controlador{

        /* ESTA FUNCION ES PARA AGREGAR UN USUARIO */
        public function Agregar(){
            global $modeloUsuario;

            $nombre = htmlspecialchars($_POST["INombre"] ?? null);
            $identificacion = htmlspecialchars($_POST["IIdentificacion"] ?? null);
            $direccion = htmlspecialchars($_POST["IDireccion"] ?? null);
            $correo = htmlspecialchars($_POST["ICorreo"] ?? null);
            $contraseña = $_POST["IContraseña"] ?? null;

            $datos = [
                "nombre" => $nombre,
                "identificacion" => $identificacion,
                "direccion" => $direccion,
                "correo" => $correo,
                "clave" => $contraseña
            ];

            if (DatosVacios($datos)) {
                return "Datos incompletos.";

            } else if(NombreInvalido($nombre)){
                return "Nombre invalido.";

            }else if (CorreoFormatoInvalido($datos)) {
                return "Formato de correo incorrecto.";

            } else if (identificacionInvalido($datos)) {
                return "Formato de identificacion incorrecto,";

            } else if (TamañoIdentificacionInvalido($datos)) {
                return "Tamaño de identificacion incorrecto.";
            }

            $datos["clave"] = password_hash($datos["clave"], PASSWORD_BCRYPT);

            return $modeloUsuario->M_UsuarioAgregar($datos);
        }


        /* ESTA FUNCION ES PARA INICIAR SESIÓN */
        public function inicioSesion(){
            global $modeloUsuario;

            $correo = htmlspecialchars($_POST["ICorreo"] ?? null);
            $contraseña = $_POST["IContraseña"] ?? null;

            $datos = [
                "correo" => $correo,
                "clave" => $contraseña
            ];

            if (DatosVacios($datos)) {
                return "Contraseña incorrecta.";
            } else if (CorreoFormatoInvalido($datos)) {
                return "Contraseña incorrecta.";
            }

            return $modeloUsuario->M_UsuarioIniciarSesion($datos);
        }


        /* ESTA FUNCION ES PARA ACTUALIZAR UN USUARIO */
        public function ActualizarUsuario($datosActuales, $datosNuevos){
            global $modeloUsuario;

            if (DatosVacios($datosNuevos)) {
                return "Datos incompletos.";

            } else if(NombreInvalido($datosNuevos["nombre"])){
                return "Nombre no valido.";

            }else if (CorreoFormatoInvalido($datosNuevos)) {
                return "Formato de correo incorrecto.";

            } else if (IdentificacionInvalido($datosNuevos)) {
                return "Formato de identificacion incorrecto.";

            } else if (TamañoIdentificacionInvalido($datosNuevos)) {
                return "Tamaño de identificacion incorrecto.";
            } 

            $id = $datosActuales["id"];
            unset($datosActuales["id"]);
            unset($datosActuales["clave"]);

            $datosNuevos = ExtraerIguales($datosActuales, $datosNuevos);
            $datosNuevos["id"] = $id;

            return $modeloUsuario->M_UsuarioActualizar($datosNuevos);
        }

        public function EliminarUsuario(){
            global $modeloUsuario;
            $id = htmlspecialchars($_POST["id"] ?? null);

            $datos = [
                "id" => $id,
                "activo" => "0"
            ];

            return $modeloUsuario->M_UsuarioEliminar($datos);
        }

        public function ObtenerTodos(){
            global $modeloUsuario;
            return $modeloUsuario->M_UsuarioObtenerTodos();
        }
    }
?>