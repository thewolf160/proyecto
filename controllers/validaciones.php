<?php
    /* LAS FUNCIONES DEVUELVEN TRUE SI EL CONTENIDO DEL DATO ES INVALIDO */
    function vacio(array $datos) : bool{

        foreach($datos as $clave => $valor){
            if($valor === ""){
                return true;
            }
        }
       return false;
    }

    function validarNombre(array $datos) : bool {
        if(preg_match('/\d/', $datos["nombre"])){
            return true;
        } 

        return false;
    }

    function correoFormato(array $datos) : bool{
        return !filter_var($datos["correo"], FILTER_VALIDATE_EMAIL);
    } 

    function identificacionFormato(array $datos) : bool {
        
        if(!preg_match('/^([V|E|J|G|P]-\d{7,8}-\d|\d{7,8})$/', $datos["identificacion"])) {
            return true;
        }

        if(strpos($datos["identificacion"], '-') !== false) {
            $partes = explode('-', $datos["identificacion"]);
            
            if(!in_array($partes[0], ['V', 'E', 'J', 'G', 'P'])) {
                return true;
            }
            
            if(!ctype_digit($partes[1]) || !ctype_digit($partes[2])) {
                return true;
            }
        }
        
        return false;
    }

    function tamañoidentificacion(array $datos) : bool {
        $identificacion = $datos["identificacion"];
    
        if(strpos($identificacion, '-') !== false) {
            $longitud = strlen(str_replace('-', '', $identificacion));
            return ($longitud < 10 || $longitud > 11); 
        
        }else {
            $longitud = strlen($identificacion);
            return ($longitud < 7 || $longitud > 8);  
        }
    }

    function ExisteUsuario($objeto) : bool{
        return $objeto !== null ? true : false;
    }


?>