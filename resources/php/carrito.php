
<?php
session_start();

$servidor = 'localhost';
$cuenta = 'root';
$password = '';
$bd = 'mamba';

$conexion = new mysqli($servidor, $cuenta, $password, $bd);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$idCliente = $_SESSION['ID'];

//Aqui hace la consulta con las condiciones
$consulta = "SELECT * FROM venta WHERE ID_Cte = '$idCliente' AND Cart = 1";
$resultado = $conexion->query($consulta);


if ($resultado) {
    $numRegistros = $resultado->num_rows;
    echo "Elementos en el carrito: $numRegistros";
} else {
    echo "Error en la consulta: " . $conexion->error;
}

$conexion->close();
?>