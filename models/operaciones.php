<?php
    include '../config/conexion.php';

    class Operaciones{

        private $conexionDB;
        
        public function __construct($servidor, $usuario, $clave, $bd) {
            $objeto = new Conexion($servidor, $usuario, $clave, $bd);
            $this->conexionDB = $objeto->conectar();
        }


        /* ESTA FUNCION ES PARA AGREGAR DATOS A LAS TABLAS */
        public function Agregar($NombreTabla, array $Datos) : array{
            try{

                $columnas = implode(", ", array_keys($Datos));
                $interrogacion = implode(", ", array_fill(0, count($Datos), "?"));

                $consulta = "INSERT INTO $NombreTabla ($columnas) VALUES ($interrogacion)";
                $stmt = $this->conexionDB->prepare($consulta);
                
                if(!$stmt){
                    return ["error" => "No se pudo prepara la consulta", "exito" => false];
                } 

                $tipoDato = $this->DetectarTiposDatos($Datos);
                $contenido = array_values($Datos);

                $stmt->bind_param($tipoDato, ...$contenido);
                
                if(!$stmt->execute()){
                    return ["error" => "Error al insertar datos", "exito" => false];
                }

                $stmt->close();

                return ["error" => "Datos insertados correctamente", "exito" => true];

            } catch (Exception $e) {
                return ["error" => "SE HA PRODUCIDO UN ERROR EN UN COMANDO. " . $e->getMessage(), "exito" => false];
            }
        }


        /* ESTA FUNCION ES PARA VERFICAR SI UN USUARIO EXISTE*/
        public function Existe($NombreTabla ,array $Datos){
            
            try{
                $columnasArreglo = array_keys($Datos);
                $columnas = implode(", ", $columnasArreglo);

                $condicion = [];

                for($i = 0; $i < count($Datos); $i++){
                    $condicion[$i] = $columnasArreglo[$i] . " = ?";
                }

                $cuando = implode(" AND ", $condicion);

                $consulta = "SELECT $columnas FROM $NombreTabla WHERE $cuando";

                $stmt = $this->conexionDB->prepare($consulta);

                if(!$stmt){
                    return ["error" => "No se pudo preparar la consulta", "exito" => false];
                }

                $tipoDato = $this->DetectarTiposDatos($Datos);
                $contenido = array_values($Datos);

                $stmt->bind_param($tipoDato, ...$contenido);

                if(!$stmt->execute()){
                    return ["error" => "Error al ejecutar la consulta", "exito" => false];
                
                } else {
                    $resultado = $stmt->get_result();
                    return $resultado->fetch_assoc();

                } 

                $stmt->close();
                return $resultado;

            } catch(Exception $e) {
                return ["error" => "SE HA PRODUCIDO UN ERROR EN UN COMANDO. " . $e->getMessage(), "exito" => false];

            }
            
        }


        /* ESTA FUNCION ES PARA DETECTAR LOS TIPOS DE DATOS DEL DICCIONARIO */
        private function DetectarTiposDatos(array $datos): string{
            $tipos = "";

            foreach($datos as $contenido){

                switch(gettype($contenido)){

                    case "integer": $tipos .= "i";  break;

                    case "double":  $tipos .= "d";   break;
                    
                    case "string":  $tipos .= "s";   break;

                    default: 
                        $tipos .= "s";
                    break;
                }
            }

            return $tipos;
        }
    }
?>