<?php
    require_once __DIR__ . '/../operaciones.php';

    $operaciones = new Operaciones("localhost", "root", "", "pincos");

    class ModeloUsuario {
        public function __construct(){}

        public function ModeloAgregar($datos){
            global $operaciones;

            $Existencia = [
                "identificacion" => $datos["identificacion"],
                "correo" => $datos["correo"],
            ];

            foreach ($Existencia as $columna => $valor) {
                if (ExisteUsuario($operaciones->Existe("usuarios", [$columna => $valor]))) {
                    return ["error" => "El usuario ya existe", "exito" => false];
                }
            }

            return $operaciones->Agregar("usuarios", $datos);
        }

        public function ModeloConsultar($datos){

            global $operaciones;

            $contraseña = $datos["clave"];
            unset($datos["clave"]);

            $resultado = $operaciones->Existe("usuarios", $datos);
            $datos["clave"] = $contraseña;

            if ($resultado === null) {
                return ["error" => "Contraseña incorrecta", "exito" => false];

            } else {
                if (password_verify($datos["clave"], $resultado["clave"])) {
                    return $resultado;

                } else {
                    return ["error" => "Contraseña incorrecta", "exito" => false];

                }
            }
        }
    }
?>