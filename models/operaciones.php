<?php
    require_once __DIR__ . '/../config/conexion.php';

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
        public function Existe($NombreTabla, array $Datos) {
            try {
                if (count($Datos) !== 1) {
                    return ["error" => "Se debe proporcionar exactamente un solo campo y valor", "exito" => false];
                }

                $columna = array_keys($Datos)[0];
                $valor = array_values($Datos)[0];

                // Construir consulta para una sola condición
                $consulta = "SELECT * FROM $NombreTabla WHERE $columna = ?";

                $stmt = $this->conexionDB->prepare($consulta);

                if (!$stmt) {
                    return ["error" => "No se pudo preparar la consulta", "exito" => false];
                }

                // Detectar tipo de dato
                $tipoDato = $this->DetectarTiposDatos($Datos);
                $stmt->bind_param($tipoDato, $valor);

                if (!$stmt->execute()) {
                    return ["error" => "Error al ejecutar la consulta", "exito" => false];
                }

                $resultado = $stmt->get_result();
                $stmt->close();

                return $resultado->fetch_assoc();

            } catch (Exception $e) {
                return ["error" => "SE HA PRODUCIDO UN ERROR EN UN COMANDO. " . $e->getMessage(), "exito" => false];

            }
        }


        /* ESTA FUNCION ES PARA ELIMINAR DATOS DE LAS TABLAS */
        public function Eliminar($NombreTabla, array $objeto) : array{
            try{

                if($this->Existe($NombreTabla, ["id" => $objeto["id"]]) !== null){
                    $consulta = "DELETE FROM $NombreTabla WHERE id = ?";
                    $stmt = $this->conexionDB->prepare($consulta);
                    
                    if(!$stmt){
                        return ["error" => "No se pudo preparar la consulta", "exito" => false];
                    } 

                    $tipoDato = $this->DetectarTiposDatos($objeto);
                    $contenido = array_values($objeto);

                    $stmt->bind_param($tipoDato, ...$contenido);
                    
                    if(!$stmt->execute()){
                        return ["error" => "Error al eliminar datos", "exito" => false];
                    }

                    $stmt->close();

                    return ["error" => "Datos eliminados correctamente", "exito" => true];

                } else {
                    return ["error" => "Datos no encontrados", "exito" => false];

                }

            } catch (Exception $e) {
                return ["error" => "SE HA PRODUCIDO UN ERROR EN UN COMANDO. " . $e->getMessage(), "exito" => false];
            }

            return ["error" => "Esta función no está implementada", "exito" => false];
        }


        /* ESTA FUNCION ES PARA MODIFICAR DATOS DE LAS TABLAS */
        public function Modificar($NombreTabla, array $objeto): array {
            try {
                if ($this->Existe($NombreTabla, ["id" => $objeto["id"]]) !== null) {
                    
                    $id = $objeto["id"];
                    unset($objeto["id"]); 

                    if (isset($objeto["identificacion"]) && $this->Existe($NombreTabla, ["identificacion" => $objeto["identificacion"]]) !== null) {
                        return ["error" => "La identificacion ya está registrada en el sistema", "exito" => false];
                    
                    } else if (isset($objeto["correo"]) && $this->Existe($NombreTabla, ["correo" => $objeto["correo"]]) !== null) {
                        return ["error" => "El correo ya está registrado en el sistema", "exito" => false];

                    } else { 
                        $columnas = implode(" = ?, ", array_keys($objeto)) . " = ?";
                        $consulta = "UPDATE $NombreTabla SET $columnas WHERE id = ?";

                        $stmt = $this->conexionDB->prepare($consulta);
                        if (!$stmt) {
                            return ["error" => "No se pudo preparar la consulta", "exito" => false];
                        }

                        $valores = array_values($objeto);
                        $valores[] = $id; 

                        $tipoDato = $this->DetectarTiposDatos($objeto) . $this->DetectarTiposDatos(["id" => $id]);

                        $stmt->bind_param($tipoDato, ...$valores);

                        if (!$stmt->execute()) {
                            return ["error" => "Error al modificar datos", "exito" => false];
                        }

                        $stmt->close();

                        return ["error" => "Datos modificados correctamente", "exito" => true];
                    }

                } else {
                    return ["error" => "Datos no encontrados", "exito" => false];
                }
            } catch (Exception $e) {
                return ["error" => "SE HA PRODUCIDO UN ERROR EN UN COMANDO. " . $e->getMessage(), "exito" => false];
            
            }
        }


        /* ESTA FUNCION ES PARA RETORNAR TODOS LOS DATOS DE LA TABLA */
        public function ObtenerTodos($NombreTabla): array {
            try {
                $consulta = "SELECT * FROM $NombreTabla";
                $stmt = $this->conexionDB->prepare($consulta);

                if (!$stmt) {
                    return ["error" => "No se pudo preparar la consulta", "exito" => false];
                }

                if (!$stmt->execute()) {
                    return ["error" => "Error al obtener datos", "exito" => false];
                }

                $resultado = $stmt->get_result();
                $stmt->close();

                return $resultado->fetch_all(MYSQLI_ASSOC);

            } catch (Exception $e) {
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
        
        public function obtenerUltimoId() {
            return $this->conexionDB->insert_id;
        }

    }
?>