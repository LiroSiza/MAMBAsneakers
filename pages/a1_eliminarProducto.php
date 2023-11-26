<?php
// Verificar si se ha enviado el valor
if (isset($_POST['valorID'])) {
    // Obtener el valor enviado por la solicitud AJAX
    $valor = $_POST['valorID'];

    // Conexión a la base de datos
    $servidor='localhost';
    $cuenta='root';
    $password='';
    $bd='mamba';

    $conexion = new mysqli($servidor,$cuenta,$password,$bd);
    mysqli_set_charset($conexion, "utf8"); //Codificación de caracteres
    
    if ($conexion->connect_errno){
         die('Error en la conexion');
    }   

    $nombreCarpeta = '../resources/img/productos/';
    // Sentencia preparada
    $sql1 = "SELECT Imagen FROM producto WHERE ID_Pto = ?";

    $stmt = $conexion->prepare($sql1);
    $stmt->bind_param("i", $valor);
    $stmt->execute();
    $stmt->bind_result($imagen);
    $stmt->fetch();
    $stmt->close();

    $nombreArchivo = $nombreCarpeta . $imagen;

    if (file_exists($nombreArchivo)) {
        if (unlink($nombreArchivo)) {
            //  echo 'La imagen ha sido eliminada correctamente.';
        } else {
        //  echo 'No se pudo eliminar la imagen.';
        }
    } else {
        //  echo 'La imagen no existe en la carpeta especificada.';
    }

    
    $sql = "DELETE FROM producto WHERE ID_Pto = $valor";
    $result = $conexion->query($sql);

} else {
    // Si no se ha enviado el valor, emitir un mensaje de error
    echo "Error: No se recibió el valor.";
}
?>
