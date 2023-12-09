<?php

    ob_start();
    session_start();


    $servidor='localhost';
    $cuenta='root';
    $password='';
    $bd='mamba';
    
    //conexion a la base de datos
    $conexion = new mysqli($servidor,$cuenta,$password,$bd);

    if ($conexion->connect_errno){
        die('Error en la conexion');
    }
    
    $usuarioID = $_SESSION["ID"];
    
    $stmt = $conexion->prepare(
        "UPDATE venta
        SET Cart=0
        WHERE ID_Cte = ?");
    $stmt->bind_param('s', $usuarioID); 
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();
    $conexion->close();




    header("Location: ../../pages/homee.php");



?>