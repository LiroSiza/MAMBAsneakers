<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAMBA - Shop</title>
    <link rel="stylesheet" href="../resources/css/shop.css">
</head>
<body>
    <?php
        // Conexión a la base de datos
        $servidor='localhost';
        $cuenta='root';
        $password='';
        $bd='mamba';

        $conexion = new mysqli($servidor,$cuenta,$password,$bd);

        if ($conexion->connect_error) {
            die("Conexión fallida: " . $conexion->connect_error);
        }
        

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $filtro = $_POST["filtro"];
            $filtro = $conexion->real_escape_string($filtro);
            if($filtro=="Ver todo"){
                $sql = 'SELECT * FROM producto';
            }else{
                $sql = "SELECT * FROM producto WHERE Categoria = '$filtro'";
            }

        } else{
            $sql = 'SELECT * FROM producto';
        }

        $resultado = $conexion -> query($sql);

    
        include('../includes/headr.html');
    ?>

    <!-- Filtro de categorias -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="filtro">Filtro por categoria:</label>
        <select name="filtro" id="filtro">
            <?php
                $query = "SELECT DISTINCT Categoria FROM producto"; 
                $result = $conexion->query($query);
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $categoria = $row['Categoria'];
                        echo '<option value="' . $categoria . '">' . $categoria . '</option>';
                    }
                    echo '<option value="Ver todo">Ver todo</option>';
                }else {
                    echo "Error en la consulta: " . $conexion->error;
                }
            ?>
        </select>
        <input type="submit" value="Aplicar">
    </form>    

    <?php
    $item = 0;
    $resultado->data_seek(0);
    while( $row = $resultado ->  fetch_assoc()){
        $id = $row['ID_Pto'];
        $nombre = $row['Nombre_Pto'];
        $categoria = $row['Categoria'];
        $existencias = $row['Existencia'];
        $precio = $row['Precio'];
        $imagen_ruta = $row['Imagen'];
        $descuento = $row['Descuento'];
    ?>

        

        <!-- Card del producto -->
        <div>
            <img  src="../resources/img/shopimages/<?php echo $imagen_ruta ?>">
            <p><?php echo $nombre ?></p>
            <p>$<?php echo $precio ?></p>
            <!-- Boton para agregar al carrito -->
            <button id="<?php echo $item ?>">Carrito</button>
        </div>
        

    <?php
            $item = $item+1;
        }

        $conexion->close();
    
        include('../includes/footer.html');
    ?>  
</body>
</html>