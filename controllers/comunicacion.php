<?php
    include "validaciones.php";
    include "../models/operaciones.php";

    $operaciones = new Operaciones("localhost", "root", "", "pincos");

    /* RECIBIMOS LA SECCION DEL FORMULARIO */
    $seccion = htmlspecialchars($_POST["seccion"] ?? null);

    switch($seccion){

        case "Registrarse":
            $resultado = RegistroUsuario();
            echo $resultado["error"];
            
        break;

        case "inicio_sesion": 
            $resultado = inicioSesion();
            echo $resultado["error"];
        
        break;

    }

    /* FUNCION PARA REGISTRAR USUARIO */
    function RegistroUsuario() : array{
        global $operaciones;

        /* RECIBIMOS LOS DATOS DEL FORMULARIO */
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

        $Existencia = [
            "identificacion" => $identificacion,
            "correo" => $correo,
        ];
            
        if (vacio($datos)){
            return ["error" => "Datos incompletos", "exito" => false];
            
        } else if(correoFormato($datos)){
            return ["error" => "Formato de correo incorrecto", "exito" => false];

        } else if(validarNombre($datos)){
            return ["error" => "Nombre no valido", "exito" => false];

        } else if(identificacionFormato($datos)){
            return ["error" => "Formato de identificacion incorrecto", "exito" => false];
        
        } else if(tamañoidentificacion($datos)){
            return ["error" => "Tamaño de identificacion incorrecto", "exito" => false];

        }

        foreach($Existencia as $columna => $valor){
            if(ExisteUsuario($operaciones->Existe("usuarios",[$columna => $valor]))){
                return $mensaje = ["error" => "El usuario ya existe", "exito" => false];
            }
        }

        $datos["clave"] = password_hash($datos["clave"], PASSWORD_BCRYPT);

        $resultado = $operaciones->Agregar("usuarios", $datos);

        return $resultado;
    }


    /* FUNCION PARA INICIAR SESIÓN */
    function inicioSesion() : array{
        global $operaciones;

        $correo = htmlspecialchars($_POST["ICorreo"] ?? null);
        $contraseña = $_POST["IContraseña"] ?? null;

        $datos = [
            "correo" => $correo, 
            "clave" => $contraseña
        ];

        if (vacio($datos)){
            return ["error" => "Datos incompletos", "exito" => false];
            
        } else if(correoFormato($datos)){
            return ["error" => "Formato de correo incorrecto", "exito" => false];
        }

        unset($datos["clave"]);
        $resultado = $operaciones->Existe("usuarios", $datos);

        $datos["clave"] = $contraseña;

        if($resultado === null){
            return ["error" => "Contraseña incorrecta", "exito" => false];
        
        } else {
            if(password_verify($datos["clave"], $resultado["clave"])){
                return $resultado;
            
            } else {
                return ["error" => "Contraseña incorrecta", "exito" => false];
            }
        }

        return ["error" => "A ocurrido un error al iniciar sesión", "exito" => false];
    }
?>