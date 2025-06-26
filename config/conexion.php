<?php

    class Conexion {

        private $servidor;
        private $usuario;
        private $clave;
        private $bd;

        public function __construct($servidor, $usuario, $clave, $bd) {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $this->servidor = $servidor;
            $this->usuario = $usuario;
            $this->clave = $clave;
            $this->bd = $bd;
        }

        public function conectar() {
            $conexion = new mysqli($this->servidor, $this->usuario, $this->clave, $this->bd);
            
            if ($conexion->connect_error) {
                return ["error" => "No se pudo conectar a la base de datos"];
            }
                
            return $conexion;
        }
    }
?>