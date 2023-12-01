<?php
    ob_start();
    session_start();
    include('../includes/headr.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAMBA - Shop</title>
    <link rel="stylesheet" href="../resources/css/shop.css">
    <script src="https://kit.fontawesome.com/a99fa1f648.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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

        $session=true;
        
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["idProducto"])) {
            if(isset($_SESSION['ID'])){
                $idCliente = $_SESSION['ID']; 
                $idProducto = $_GET["idProducto"];
                $cantidad = 1; 
                $cart = 1; 
                
                $session=true;

                $sql = "INSERT INTO venta (ID_Cte, ID_Prod, Cantidad, Cart) VALUES ('$idCliente', '$idProducto', '$cantidad', '$cart')";
            
                if ($conexion->query($sql) === TRUE) {
                    echo '<script src="../resources/js/shop.js"></script>';
                    echo '<script>var escenario = "agregarCarrito";</script>';
                } else {
                    echo '<script src="../resources/js/shop.js"></script>';
                    echo '<script>var escenario = "agregarError";</script>';
                }
            }
            else{
                $session=false;
            }
            
            
        }
        

    ?>

    <!-- Filtro de categorias -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="filtro"><i class="fa-solid fa-filter" style="color: #ff7300;"></i> Filtro por categoria:</label>
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
    
    
    

    <div>
        <?php
        if($session==false){
            echo '<script src="../resources/js/shop.js"></script>';
            echo '<script>var escenario = "errorSesion";</script>';
        }
        ?>
    </div>


    <div class="card-container">
    <?php
    $item = 0;
    $resultado->data_seek(0);
    while( $row = $resultado ->  fetch_assoc()){
        $id = $row['ID_Pto'];
        $nombre = $row['Nombre_Pto'];
        $categoria = $row['Categoria'];
        $descripcion = $row['Descripcion'];
        $existencias = $row['Existencia'];
        $agotado= ($existencias == 0) ? 'text-decoration : line-through ; ' : '';
        $precio = $row['Precio'];
        $imagen_ruta = $row['Imagen'];
        $descuento = $row['Descuento'];
    
    ?>

         <!-- Card del producto -->
        <div>
            <div class="card">
                <div style="text-align: end;">
                    <button>...</button>
                </div>
                <img  src="../resources/img/shopimages/<?php echo $imagen_ruta ?>">
                <center> <p id="nombre" style="<?php echo $agotado; ?>"><?php echo $nombre ?></p></center>
                <p><strong>Categoria:</strong> <?php echo $categoria; ?></p>
                <p><strong>Descripcion:</strong> <?php echo $descripcion; ?></p>
                <p><strong>Existencias:</strong> <?php echo $existencias; ?></p>
                <?php if ($descuento>0) : ?>
                    <p><strong>Precio con descuento: </strong>$<?php echo number_format($precio - $descuento,2); ?></p>
                    <p><strong>Precio original: </strong>$<?php echo number_format($precio,2); ?></p>
                <?php else: ?>
                    <p><strong>Precio: </strong>$<?php echo number_format($precio,2); ?></p>
                <?php endif; ?>
                <?php if ($existencias>0) : ?>
                    
                <!-- Boton para agregar al carrito -->
                <div style="text-align: center;">
                <button onclick="agregar(<?php echo $id;?>,<?php echo $existencias;?>)" id="<?php echo $item ?>" class="carrote"><img src="../resources/img/shopimages/carrito.jpg" alt="" width="20px" height="20px">    Agregar al carrito</button>
                </div>
                <?php else: ?>
                <p style="color: grey; font-weight:bold;">AGOTADO</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Script agregar al carrito cuando se de click al boton -->
        <script>
            function agregar(idProducto, existencias){
                if(existencias>0){
                    window.location.href = '?idProducto=' + idProducto;
                }else{
                    alert ('Producto agotado');
                }
            }
        </script>
    
    <?php
            $item = $item+1;
        } ?>
    </div> 
    <?php 
        $conexion->close();
    
        include('../includes/footer.html');
    ?>
</body>
</html>