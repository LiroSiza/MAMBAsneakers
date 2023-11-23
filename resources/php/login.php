<?php
ob_start(); //por si no funciona el header location (activa almacenamiento en buffer de salida)
$config['base_url'] = 'http://' . $_SERVER["SERVER_NAME"]; //nombre del servidor(dominio) en el que estas actualmente
//require 'formulario.php';  ARCHIVO HEADER???



    $usuario = $_POST["usuario"];
    $palabra_secreta = $_POST["palabra_secreta"];


    $servidor='localhost';
    $cuenta='root';
    $password='';
    $bd='mamba';
     
    //conexion a la base de datos
    $conexion = new mysqli($servidor,$cuenta,$password,$bd);

    if ($conexion->connect_errno){
         die('Error en la conexion');
    }
    
   $stmt = $conexion->prepare("SELECT * FROM usuario WHERE Usuario = ? AND Password_Usr = ?");
   $stmt->bind_param('ss', $usuario, $palabra_secreta); 
   $stmt->execute();
   $res = $stmt->get_result();

    if($res->num_rows>0){
        $fila=$res->fetch_assoc();
        $ID=$fila['ID'];
        $Nombre_Usr=$fila['Nombre_Usr'];
        $correo=$fila['Correo_Usr'];
        $pregSeguridad=$fila['PregSeguridad'];

        
        $stmt->close();
        $conexion->close();

        session_start();
        $_SESSION["usuario"] = $usuario;
        $_SESSION["ID"] = $ID;
        $_SESSION["Nombre_Usr"] = $Nombre_Usr;
        $_SESSION["correo"] = $correo;
        $_SESSION["pregSeguridad"] = $pregSeguridad;

        
        

        # Luego redireccionamos a la pagina "Secreta"
        # redireccionamiento con php
        header("Location: ../../pages/homee.php");
        //header("Location:".$base_url."secreta.php");

        # redireccionamiento con javascript   
        //echo '<script>window.location="'.$base_url.'secreta.php"</script>';
        
    } else {
        # No coinciden, asi  que simplemente imprimimos un
        # mensaje diciendo que es incorrecto
         
        $stmt->close();
        $conexion->close();
        echo "incorrect";

        //include("../loginIncorrecto.php");
        

    }

    ?>