<?php
    // session_start();

    // Verificar si la sesión del carrito existe, si no, crearla
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

  // Agregar producto al carrito
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["idProducto"])) {
    $idProducto = $_GET["idProducto"];

    // Conexión a la base de datos
    $servidor = 'localhost';
    $cuenta = 'root';
    $password = '';
    $bd = 'mamba';

    $conexion = new mysqli($servidor, $cuenta, $password, $bd);

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Obtener las existencias actuales del producto desde la base de datos
    $sqlExistencias = "SELECT Existencia FROM producto WHERE ID_Pto = '$idProducto'";
    $resultExistencias = $conexion->query($sqlExistencias);

    if ($resultExistencias !== FALSE && $resultExistencias->num_rows > 0) {
        $rowExistencias = $resultExistencias->fetch_assoc();
        $existenciasActuales = $rowExistencias['Existencia'];

        // Verificar si hay existencias suficientes para agregar al carrito
        if ($existenciasActuales > 0) {
            // Agregar el producto al carrito
            if (array_key_exists($idProducto, $_SESSION['carrito'])) {
                $_SESSION['carrito'][$idProducto]++;
            } else {
                $_SESSION['carrito'][$idProducto] = 1;
            }

            // Actualizar las existencias en la base de datos
            $nuevasExistencias = $existenciasActuales - 1; // Restar una unidad al agregar al carrito
            $sqlActualizarExistencias = "UPDATE producto SET Existencia = '$nuevasExistencias' WHERE ID_Pto = '$idProducto'";
            if ($conexion->query($sqlActualizarExistencias) !== TRUE) {
                echo "Error al actualizar las existencias: " . $conexion->error;
            }
        } else {
            echo "No hay existencias suficientes para este producto.";
        }
    } else {
        echo "Error al obtener las existencias del producto: " . $conexion->error;
    }

    $conexion->close();
}


// Eliminar producto del carrito
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["eliminar"])) {
    $idEliminar = $_GET["eliminar"];

    // Verificar si el producto está en el carrito
    if (array_key_exists($idEliminar, $_SESSION['carrito'])) {
        // Reducir la cantidad o eliminar el producto si es 1
        if ($_SESSION['carrito'][$idEliminar] > 1) {
            $_SESSION['carrito'][$idEliminar]--;
            $cantidadEliminar = 1; // Cantidad que se eliminará del carrito
        } else {
            $cantidadEliminar = $_SESSION['carrito'][$idEliminar];
            unset($_SESSION['carrito'][$idEliminar]);
        }

        // Conexión a la base de datos
        $servidor = 'localhost';
        $cuenta = 'root';
        $password = '';
        $bd = 'mamba';

        $conexion = new mysqli($servidor, $cuenta, $password, $bd);

        if ($conexion->connect_error) {
            die("Conexión fallida: " . $conexion->connect_error);
        }

        // Actualizar la tabla de ventas en la base de datos (eliminar el registro)
        $idCliente = $_SESSION['ID']; // Asegúrate de tener el ID del cliente en la sesión
        $sql = "DELETE FROM venta WHERE ID_Cte = '$idCliente' AND ID_Prod = '$idEliminar' AND Cart = 1";
        if ($conexion->query($sql) !== TRUE) {
            echo "Error al eliminar el producto del carrito: " . $conexion->error;
        }

        // Obtener las existencias actuales del producto
        $sqlExistencias = "SELECT Existencia FROM producto WHERE ID_Pto = '$idEliminar'";
        $resultExistencias = $conexion->query($sqlExistencias);

        if ($resultExistencias && $resultExistencias->num_rows > 0) {
            $rowExistencias = $resultExistencias->fetch_assoc();
            $existenciasActuales = $rowExistencias['Existencia'];

            // Incrementar las existencias con la cantidad a eliminar
            $nuevasExistencias = $existenciasActuales + $cantidadEliminar;

            // Actualizar las existencias en la base de datos
            $sqlActualizarExistencias = "UPDATE producto SET Existencia = '$nuevasExistencias' WHERE ID_Pto = '$idEliminar'";
            if ($conexion->query($sqlActualizarExistencias) !== TRUE) {
                echo "Error al actualizar las existencias del producto: " . $conexion->error;
            }
        } else {
            echo "Error al obtener las existencias del producto.";
        }

        $conexion->close();
    }
}


    // Conexión a la base de datos
    $servidor='localhost';
    $cuenta='root';
    $password='';
    $bd='mamba';

    $conexion = new mysqli($servidor,$cuenta,$password,$bd);

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
<style>

    /* Estilos para cada producto en el carrito */
    .product {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
       margin-bottom: 30px;
    }

    /* Efecto de hover sobre el producto */
    .product:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    /* Estilos para los detalles del producto */
    .product-details {
        color: #333;
    }

    /* Estilos para el botón de eliminar */
    .btn {
        background-color: #e74c3c;
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.3s ease-in-out;
    }

    /* Efecto de hover sobre el botón de eliminar */
    .btn:hover {
        background-color: #c0392b;
    }

    .empty-cart-message {
        text-align: center;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .empty-cart-message p {
        font-size: 18px;
        color: #333;
        margin: 0;
    }

    .empty-cart-message:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

</style>
</head>
<body>
<!-- Contenido HTML con el bucle PHP -->
<div class="cart-products">
    <?php
    if (empty($_SESSION['carrito'])) {
        // Si el carrito está vacío, muestra un mensaje
        echo '<div class="empty-cart-message">';
        echo '<p>Tu carrito está vacío.</p>';
        echo '</div>';
    } else {
        foreach ($_SESSION['carrito'] as $idProducto => $cantidad) {
            $sql = "SELECT * FROM producto WHERE ID_Pto = '$idProducto'";
            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    // Detalles del producto (nombre, descripción, precio, cantidad)
                    echo '<div class="product">';
                    echo '<div class="product-details">';
                    echo '<h4 class="product-name">' . $row['Nombre_Pto'] . '</h4>';
                    echo '<p class="product-description">' . $row['Descripcion'] . '</p>';
                    echo '<p class="product-price">$' . $row['Precio'] . '</p>';
                    echo '<p class="product-quantity">Cantidad: ' . $cantidad . '</p>';
                    // Botón para eliminar el producto del carrito
                    echo '<a href="?eliminar=' . $idProducto . '" class="btn btn-danger">Eliminar</a>';
                    echo '</div>'; // Cierre de product-details
                    echo '</div>'; // Cierre de product
                }
            }
        }
    }
    ?>
</div>



    
    <?php 
        $conexion->close();
        // Otro contenido HTML o inclusión de footer
    ?>
</body>
</html>
