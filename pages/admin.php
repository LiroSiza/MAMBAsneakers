<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../resources/css/admin.css">
    <title>MAMBA-Admin</title>
</head>
<body>
    <?php
        include('../includes/headr.php');
    ?>
    <br>
    <div class="container">
        <div class="sidebar">
            <h3>Buscar</h3>
            <form class="search-form">
                <label for="category">Categoría:</label>
                <select id="category" name="category">
                    <option value="hombre">Hombre</option>
                    <option value="mujer">Mujer</option>
                </select>
                <br>
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name">
                <br><br>
                <button type="submit" id="btnenviar">Enviar</button>
            </form>
            <br><br>
            <div class="buttons">
                <button>Mostrar Todos</button>
                <br><br>
                <button>Ordenar por $</button>
                <br><br>
                <button>Ordenar por Disponibilidad</button>
                <br><br>
            </div>
        </div>
        <div class="main-content">
            <h1>REGISTROS</h1>
            <hr>
            <!-- Contenido de la columna derecha aquí -->
        </div>
    </div>
    <br><br><br>
        <?php
            include('../includes/footer.html');
        ?>

</body>
</html>