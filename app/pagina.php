<?php

    $accion=isset($_POST["accion"]) ? $_POST["accion"]: NULL; //Si no esta definido, no actuo
    $correo=isset($_POST["correo"]) ? $_POST["correo"] : NULL;
    $clave=isset($_POST["clave"]) ? $_POST["clave"]:NULL;


  

    $host = "localhost";
    $user = "root";
    $password = "";
    $base = "usuarios_test";


    switch($accion)
    {
        case "Login":   
             $conexion=mysqli_connect($host,$user,$password,$base); //los otros parametros son opcionales
             $mostre=true;
             if(!$conexion)
             {
                echo "<br> Error al conectar a la base de datos. <br>";
                return;
             }           

                        
            //debo mostrar nombre y descripcion
            $consulta="SELECT usuarios.nombre, perfiles.descripcion, usuarios.correo, usuarios.clave
            FROM usuarios
            INNER JOIN perfiles ON usuarios.perfil=perfiles.id";

            $resultado=$conexion->query($consulta);
            while($fila=$resultado->fetch_object())
            {
                $registros[]=$fila;
            }
           
            foreach($registros as $usuario)
            {
                if($usuario->correo === $correo && $usuario->clave === $clave)
                {
                    $mostre=false;
                    echo "correo usuario:" .$usuario->correo. "<br>" .
                         "descripcion usuario: " . $usuario->descripcion;
                    
                    break;
                }

            }

            if($mostre)
            {
                echo "usuario no encontrado.";
            }      

            mysql_close($conexion);
            break;


        case "Mostrar":
            //(ID, CORREO, CLAVE, NOMBRE, PERFIL (CODIGO) Y PERFIL (DESCRIPCION))  <-debo mostrar.
            $noMostre=true;
            $conexion=mysqli_connect($host,$user,$password,$base);
            if(!$conexion)
            {
                echo "Error, no se pudo establecer conexion.";
                return;
            }

            $query="SELECT usuarios.id, usuarios.clave, usuarios.nombre, usuarios.perfil, perfiles.descripcion
                    FROM usuarios
                    INNER JOIN perfiles ON usuarios.perfil=perfiles.id";

            
            $resultado=$conexion->query($query);
           

            while($registro=$resultado->fetch_object())
            {
                $registros[]=$registro;
            }

            foreach($registros as $registro)
            {
                $noMostre=false;
                echo  "<br>"."descripcion del perfil: " . $registro->descripcion . "<br>";
                          
                echo   "id usuario: " . $registro->id. "<br>";

                echo  "nombre usuario: " . $registro->nombre . "<br>";

                echo  "numero de perfil: " . $registro->perfil ."<br";

                echo  "descripcion del perfil: " . $registro->descripcion . "<br>";

                echo  "clave: " .$registro->clave . "<br>";  
            }


            if($noMostre)
            {
                echo "Error.";
            }


            mysql_close($conexion);
            break;

        default:
            echo "Error, verifique que las opciones esten bien escritas.";
        break;
    }




?>