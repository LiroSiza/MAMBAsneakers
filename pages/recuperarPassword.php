<?php
    ob_start();
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../resources/css/estiloRecuperarPass.css">
    <title>Document</title>
</head>
<?php
    include('../includes/headr.php');
?>
<body class="recoverPass">
    <?php
        
        if(isset($_POST["submit3"])){
            $servidor='localhost';
            $cuenta='root';
            $password='';
            $bd='mamba';
             
            $correo=$_SESSION["correoRecover"];
            $respuesta=$_SESSION["respuesta"];    

            //conexion a la base de datos
            $conexion = new mysqli($servidor,$cuenta,$password,$bd);
        
            if ($conexion->connect_errno){
                 die('Error en la conexion');
            }
            
            $stmt = $conexion->prepare("UPDATE usuario SET Password_Usr = ? WHERE Correo_Usr = ?");
            $stmt->bind_param('ss', $_POST["password"], $correo); 
            $stmt->execute();
            $res = $stmt->get_result();
            header("Location: homee.php");
            
        
        }else if(isset($_POST["submit2"])){
            $servidor='localhost';
            $cuenta='root';
            $password='';
            $bd='mamba';
             
            //conexion a la base de datos
            $conexion = new mysqli($servidor,$cuenta,$password,$bd);
        
            if ($conexion->connect_errno){
                 die('Error en la conexion');
            }
            
            $stmt = $conexion->prepare("SELECT RespuestaPregSeg FROM usuario WHERE Correo_Usr = ?");
            $stmt->bind_param('s', $_SESSION["correoRecover"]); 
            $stmt->execute();
            $res = $stmt->get_result();

            $correo=$_SESSION["correoRecover"];
            $_SESSION["respuesta"]=$_POST["respuesta"];
        
            if($res->num_rows>0){
                $fila=$res->fetch_assoc(); 
                $respSeguridad=$fila['RespuestaPregSeg'];
                if($respSeguridad==$_POST["respuesta"]){
                    ?>
                        <div class="recPass">
                            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Ingresa tu nueva contraseña</label>
                                    <input type="password"  class="form-control" id="password1" required oninput="validarContrasenas1()" aria-describedby="emailHelp">
                                    <label for="exampleInputEmail1" class="form-label">Confirma tu nueva contraseña</label>
                                    <input type="password" name="password" class="form-control" id="confirmPassword1" required oninput="validarContrasenas1()" aria-describedby="emailHelp">
                                    <h6 id="mensajeError1" style="color:red;"></h6>
                                </div>
                                <button type="submit" id="submitButton1" name="submit3" class="btn btn-primary">Enviar</button>
                            </form>
                        </div> 
                    <?php
                }else{
                    echo "Respuesta incorrecta";
                    session_destroy();
                }
            }
    ?>

        

    <?php
        }else if(isset($_POST["submit"])){
            $servidor='localhost';
            $cuenta='root';
            $password='';
            $bd='mamba';
             
            //conexion a la base de datos
            $conexion = new mysqli($servidor,$cuenta,$password,$bd);
        
            if ($conexion->connect_errno){
                 die('Error en la conexion');
            }
            
            $stmt = $conexion->prepare("SELECT PregSeguridad FROM usuario WHERE Correo_Usr = ?");
            $stmt->bind_param('s', $_POST["correo"]); 
            $stmt->execute();
            $res = $stmt->get_result();
        
            if($res->num_rows>0){
                $fila=$res->fetch_assoc(); 
                $pregSeguridad=$fila['PregSeguridad'];
            

                $_SESSION["correoRecover"]=$_POST["correo"];
    ?>
                <div class="recPass">
                    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label"><?php echo $pregSeguridad; ?></label>
                            <input type="text" name="respuesta" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">Sé lo mas preciso posible en cuanto a ortografía.</div>
                        </div>
                        <button type="submit" name="submit2" class="btn btn-primary">Enviar</button>
                    </form>
                </div> 
    <?php
            }else{
                echo "Correo no registrado";
                session_destroy();
            }
        }else{
    ?>
            <div class="recPass">
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Ingresa tu correo</label>
                        <input type="email" name="correo" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div> 
    <?php
        }
    ?>    
</body>
<script src="../resources/js/cambioPassword.js"></script>
</html>
