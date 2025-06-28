<?php
    require_once __DIR__ . '/../../validators/validaciones.php';
    require_once __DIR__ . '/../../models/models_user/modelo_usuario.php';

    /* RECIBIMOS LA SECCION DEL FORMULARIO */
    $seccion = htmlspecialchars($_POST["seccion"] ?? null);
    $modelo = new ModeloUsuario();
    $controlador = new Controlador_Usuario("", "", "", "", "");

    switch ($seccion) {

        case "Registrarse":
            $resultado = $controlador->Agregar();
            echo $resultado["error"];

        break;

        case "inicio_sesion":
            $resultado = $controlador->inicioSesion();
            if(isset($resultado["error"])){
                echo $resultado["error"];

            } else {
                echo "Bienvenido " . $resultado["nombre"];
            }

        break;
    }


    class Controlador_Usuario {
        private $nombre;
        private $identificacion;
        private $direccion;
        private $correo;
        private $clave;

        public function __construct($nombre, $identificacion, $direccion, $correo, $clave){
            $this->nombre = $nombre;
            $this->identificacion = $identificacion;
            $this->direccion = $direccion;
            $this->correo = $correo;
            $this->clave = $clave;
        }

        public function Agregar(){
            global $modelo;

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

            if (vacio($datos)) {
                return ["error" => "Datos incompletos", "exito" => false];

            } else if(validarNombre($datos)){
                return ["error" => "Nombre no valido", "exito" => false];

            }else if (correoFormato($datos)) {
                return ["error" => "Formato de correo incorrecto", "exito" => false];

            } else if (validarNombre($datos)) {
                return ["error" => "Nombre no valido", "exito" => false];

            } else if (identificacionFormato($datos)) {
                return ["error" => "Formato de identificacion incorrecto", "exito" => false];

            } else if (tamañoidentificacion($datos)) {
                return ["error" => "Tamaño de identificacion incorrecto", "exito" => false];
            }

            $datos["clave"] = password_hash($datos["clave"], PASSWORD_BCRYPT);

            return $modelo->ModeloAgregar($datos);
        }

        public function inicioSesion(): array{
            global $modelo;

            $correo = htmlspecialchars($_POST["ICorreo"] ?? null);
            $contraseña = $_POST["IContraseña"] ?? null;

            $datos = [
                "correo" => $correo,
                "clave" => $contraseña
            ];

            if (vacio($datos)) {
                return ["error" => "Contraseña incoreccta", "exito" => false];

            } else if (correoFormato($datos)) {
                return ["error" => "Formato de correo incorrecto", "exito" => false];
                
            }

            return $modelo->ModeloConsultar($datos);
        }
    }
?>
