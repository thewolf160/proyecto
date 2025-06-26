<?php
    include "validaciones.php";
    include "../models/operaciones.php";

    $operaciones = new Operaciones("localhost", "root", "", "pincos");

    /* RECIBIMOS LA SECCION DEL FORMULARIO */
    $seccion = htmlspecialchars($_POST["seccion"] ?? null);

    switch($seccion){

        case "Registrarse":
            $resultado = Registro();
            echo $resultado["error"];
            
        break;

    }

    function Registro() : array{
        global $operaciones;

        /* RECIBIMOS LOS DATOS DEL FORMULARIO */
        $nombre = htmlspecialchars($_POST["INombre"] ?? null);
        $identificacion = htmlspecialchars($_POST["IIdentificacion"] ?? null);
        $direccion = htmlspecialchars($_POST["IDireccion"] ?? null);
        $correo = htmlspecialchars($_POST["ICorreo"] ?? null);
        $contraseña = htmlspecialchars($_POST["IContraseña"] ?? null);

        $contraseña = password_hash($contraseña, PASSWORD_BCRYPT);

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
            return $mensaje = ["error" => "Datos incompletos", "exito" => false];
            
        } else if(correoFormato($datos)){
            return $mensaje = ["error" => "Formato de correo incorrecto", "exito" => false];

        } else if(identificacionFormato($datos)){
            return $mensaje = ["error" => "Formato de identificacion incorrecto", "exito" => false];
        
        } else if(tamañoidentificacion($datos)){
            return $mensaje = ["error" => "Tamaño de identificacion incorrecto", "exito" => false];

        }

        foreach($Existencia as $columna => $valor){
            if(ExisteUsuario($operaciones->Existe("usuarios",[$columna => $valor]))){
                return $mensaje = ["error" => "El usuario ya existe", "exito" => false];
            }
        }


        $mensaje = $operaciones->Agregar("usuarios", $datos);

        return $mensaje;
    }
?>