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
            header("location: ./../../views/registro.php");
            exit();
        break;

        case "inicio_sesion":
            $resultado = $controlador->inicioSesion();
            $_SESSION["usuario"] = $resultado;
            header("location: ./../../views/inicio.php");
            exit();
        break;

        case "CerrarSesion":
            header("location: ./../../views/inicio.php");
            exit();
        break;

        case "ActualizarUsuario":
            $resultado = $controlador->ActualizarUsuario($datosNuevos);
        break;


        case "BarraBusqueda":
            $resultado = $controlador->BarraBusqueda();
        break;

        case "MostrarTodos":
            $resultado = $controlador->ObtenerTodos();
        break;
    }

    class Usuario_Controlador{

        /* ESTA FUNCION ES PARA AGREGAR UN USUARIO */
        public function Agregar(){
            global $modeloUsuario;
            $datos = $this->ValidarDatos();

            return is_string($datos) ? $datos : $modeloUsuario->M_UsuarioAgregar($datos);
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

            if (DatosVacios($datos) || CorreoFormatoInvalido($datos)) return "Contraseña incorrecta.";
    
            return $modeloUsuario->M_UsuarioIniciarSesion($datos);
        }


        /* ESTA FUNCION ES PARA ACTUALIZAR UN USUARIO */
        public function ActualizarUsuario($datosActuales){
            global $modeloUsuario;

            $datosNuevos = $this->ValidarDatos();

            if(is_string($datosNuevos)) return $datosNuevos;

            $id = $datosActuales["id"];
            unset($datosActuales["id"]);
            unset($datosActuales["clave"]);

            $datosNuevos = ExtraerIguales($datosActuales, $datosNuevos);
            $datosNuevos["id"] = $id;

            return $modeloUsuario->M_UsuarioActualizar($datosNuevos);
        }


        /* ESTA FUNCION ES PARA ELIMINAR UN USUARIO */
        public function EliminarUsuario(){
            global $modeloUsuario;
            $id = htmlspecialchars($_POST["id"] ?? null);

            $datos = [
                "id" => $id,
                "activo" => "0"
            ];

            return $modeloUsuario->M_UsuarioEliminar($datos);
        }


        /* ESTA FUNCION ES PARA OBTENER TODOS LOS USUARIOS */
        public function ObtenerTodos(){
            global $modeloUsuario;
            return $modeloUsuario->M_UsuarioObtenerTodos();
        }


        /* ESTA FUNCION ES PARA BUSCAR USUARIOS */
        public function BarraBusqueda(){
            global $modeloUsuario;
            $busqueda = htmlspecialchars($_POST["IBusqueda"] ?? null);
            if(DatosVacios(["busqueda" => $busqueda]))  return "Datos incompletos.";
            return $modeloUsuario->M_UsuarioBusqueda($busqueda);
        }


        /* ESTA FUNCION ES PARA VALIDAR LOS DATOS DEL USUARIO */
        public function ValidarDatos(){
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
            return $datos;
        }
    }
?>
