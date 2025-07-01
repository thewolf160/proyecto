<?php
    require_once __DIR__ . '/../config/conexion.php';

    class Operaciones{

        private $conexionDB;
        
        public function __construct($servidor, $usuario, $clave, $bd) {
            $objeto = new Conexion($servidor, $usuario, $clave, $bd);
            $this->conexionDB = $objeto->conectar();
        }


        /* ESTA FUNCION ES PARA AGREGAR DATOS A LAS TABLAS */
        public function Agregar($NombreTabla, array $Datos){
            try{
                $columnas = implode(", ", array_keys($Datos));
                $interrogacion = implode(", ", array_fill(0, count($Datos), "?"));

                $consulta = "INSERT INTO $NombreTabla ($columnas) VALUES ($interrogacion)";
                $stmt = $this->conexionDB->prepare($consulta);
                
                if(!$stmt) {  return false; }

                $tipoDato = $this->DetectarTiposDatos($Datos);
                $contenido = array_values($Datos);

                $stmt->bind_param($tipoDato, ...$contenido);
                
                if(!$stmt->execute()) { return false; }

                $stmt->close();

                return true;

            } catch (Exception $e) {
                return $e->getMessage();
            }
        }


        /* ESTA FUNCION ES PARA CONSULTAR */
        public function Consultar($NombreTabla, array $Datos){
            try {
                $columna = array_keys($Datos)[0];
                $valor = array_values($Datos)[0];

                $consulta = "SELECT * FROM $NombreTabla WHERE $columna = ?";

                $stmt = $this->conexionDB->prepare($consulta);

                if (!$stmt) { return false; }

                // Detectar tipo de dato
                $tipoDato = $this->DetectarTiposDatos($Datos);
                $stmt->bind_param($tipoDato, $valor);

                if (!$stmt->execute()) { return false; }

                $resultado = $stmt->get_result();
                $stmt->close();

                return $resultado->fetch_assoc();

            } catch (Exception $e) {
                return $e->getMessage();
            }
        }


        /* ESTA FUNCION ES PARA ELIMINAR DATOS DE LAS TABLAS */
        public function Eliminar($NombreTabla, array $objeto){
            try{
                $consulta = "DELETE FROM $NombreTabla WHERE id = ?";
                $stmt = $this->conexionDB->prepare($consulta);
                    
                if(!$stmt) { return false; }

                $tipoDato = $this->DetectarTiposDatos($objeto);
                $contenido = array_values($objeto);

                $stmt->bind_param($tipoDato, ...$contenido);
                    
                if(!$stmt->execute()) { return false; }

                $stmt->close();

                return true;

            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        /* ESTA FUNCION ES PARA MODIFICAR DATOS DE LAS TABLAS */
        public function Modificar($NombreTabla, array $objeto){
            try {
                $id = $objeto["id"];
                unset($objeto["id"]); 

                $columnas = implode(" = ?, ", array_keys($objeto)) . " = ?";
                $consulta = "UPDATE $NombreTabla SET $columnas WHERE id = ?";

                $stmt = $this->conexionDB->prepare($consulta);
                if (!$stmt) { return false; }

                $valores = array_values($objeto);
                $valores[] = $id; 

                $tipoDato = $this->DetectarTiposDatos($objeto) . $this->DetectarTiposDatos(["id" => $id]);

                $stmt->bind_param($tipoDato, ...$valores);

                if (!$stmt->execute()) {  return false; }

                $stmt->close();

                $objeto = $this->Consultar($NombreTabla, ["id" => $id]);

                return $objeto;

            } catch (Exception $e) {
                return $e->getMessage();
            
            }
        }


        /* ESTA FUNCION ES PARA RETORNAR TODOS LOS DATOS DE LA CONSULTA */
        public function ObtenerTodos($consulta){
            try{
                $stmt = $this->conexionDB->prepare($consulta);

                if (!$stmt)  return "ERROR EN SERVIDOR";

                if (!$stmt->execute()) { return "ERROR EN SERVIDOR"; }

                $resultado = $stmt->get_result();
                $stmt->close();

                $resultado->fetch_all(MYSQLI_ASSOC);

                if($resultado === null) return "Datos no encontrados";
                return $resultado;
                
            } catch (Exception $e) {
                return $e->getMessage();
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