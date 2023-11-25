<?php
    $servidor='localhost';
    $cuenta='root';
    $password='';
    $bd='mamba';
    

     
    //conexion a la base de datos
    $conexion = new mysqli($servidor,$cuenta,$password,$bd);
    mysqli_set_charset($conexion, "utf8"); //Codificación de caracteres


    if ($conexion->connect_errno){
         die('Error en la conexion');
    }

    else{
         //conexion exitosa

         /*revisar si traemos datos a insertar en la bd  dependiendo
         de que el boton de enviar del formulario se le dio clic*/

            if(isset($_POST['submit'])){
                $preguntas = array(
                    "mascota" => "¿Cual es tu mascota favorita?",
                    "deporte" => "¿Cual es tu deporte favorito?",
                    "apodo" => "¿Cual era tu apodo de pequeñ@?",
                    "heroe" => "¿Quien era el heroe de tu infancia?",
                    "amigo" => "¿Cual es el nombre de tu mejor amigo?",
                    "vacaciones" => "¿Donde fuiste de vacaciones el año pasado?"
                );

                //obtenemos datos del formulario
                $nom_Usuario = $_POST['nombre'];
                $alias_Usuario =$_POST['cuenta'];
                $correo_Usuario = $_POST['email'];
                $preg_Seguridad = $_POST['pregunta'];
                $resp_Pregunta = $_POST['respuesta'];
                $contra_Usuario =$_POST['contra'];

                //Esto es para colocar como tal la pregunta de seguridad en la DB
                $preguntaSeg = $preguntas[$preg_Seguridad];

                //Para encriptar la contraseña
                $contra_enc = password_hash($contra_Usuario, PASSWORD_BCRYPT);
                
                //Hacemos cadena con la sentencia mysql para insertar datos
                $sql = "INSERT INTO usuario (Usuario, Correo_Usr, Password_Usr, PregSeguridad, Nombre_Usr, RespuestaPregSeg) VALUES('$alias_Usuario','$correo_Usuario','$contra_enc','$preguntaSeg','$nom_Usuario','$resp_Pregunta')";
                $conexion->query($sql);  //aplicamos sentencia que inserta datos en la tabla usuarios de la base de datos
                if ($conexion->affected_rows >= 1) { // Revisamos que se insertó un registro
                    // Estilos de la ALERT

                    echo '<style>
                            .custom-alert {
                                position: fixed;
                                top: 50%;
                                left: 50%;
                                transform: translate(-50%, -50%);
                                padding: 25px;
                                background-color: #f8f9fa; 
                                color: #343a40; 
                                border-radius: 10px;
                                box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: center;
                                max-width: 400px;
                                text-align: center;
                            }
                            .highlight {
                                color: rgb(255, 128, 0); 
                                font-weight: bold;
                                margin-bottom: 10px;
                            }
                            .close-btn {
                                cursor: pointer;
                                font-size: 24px;
                                font-weight: bold;
                                align-self: flex-end;
                            }

                            .close-btn:hover {
                                color: rgb(255, 50, 0); 
                            }

                          </style>';
                
                    echo '<div class="custom-alert">
                            <span class="highlight">Registro Exitoso</span>
                            <span>¡Tu registro ha sido realizado con éxito!</span>
                            <span class="close-btn" onclick="this.parentElement.style.display=\'none\'">&times;</span>
                          </div>';
                }
         }//fin  
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- <link rel="stylesheet" href="../resources/css/header.css"> -->
        <script src="https://kit.fontawesome.com/0d4c0ee316.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../resources/css/header.css">
        <script src="../resources/js/header.js"></script>
    </head>
    <body id="body">
        <nav class="nav-container">
            <div id="logoImg">
                <h1 id="logo" style="color: rgb(255,128,0);">LOGO</h1>
            </div>
            <!-- LINES -->
            <div class="hamburger">
                <!-- <i class="fa-solid fa-bars"></i> -->
                <span class="lines"></span>
                <span class="lines"></span>
                <span class="lines"></span>
            </div>
            
            <ul id="nav-links">
                <li class="navL"><a href="homee.php" class="links">Home</a></li>
                <li class="navL"><a href="shop.php" class="links">Shop</a></li>
                <li class="navL"><a href="about.php" class="links">About</a></li>
                <li class="navL"><a href="help.php" class="links">Help</a></li>
                <li class="navL"><a href="contact.php" class="links">Contact</a></li>
                <li class="navL"><a href="#" class="links"><img id="bagShop" src="../resources/img/iconos/bagShop.ico" width="25px"/></a></li>
                <li class="links" class="navL"><button type="button" id="dropdownMenu1" data-toggle="dropdown" class="custom-button dropdown-toggle">Login <span class="caret"></span></button>
                
                <ul class="dropdown-menu dropdown-menu-right mt-2">
                    <li class="px-3 py-2">
                        <form class="form" role="form" action="php/login.php" method="post">
                            <div class="form-group">
                                <input name="email" id="emailInput" placeholder="Email" class="form-control form-control-sm" type="email" required="">
                            </div>
                            <div class="form-group">
                                <input name="palabra_secreta" id="passwordInput" placeholder="Password" class="form-control form-control-sm" type="password" required="">
                            </div>
                                
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                            <div class="form-group text-center">
                                <small><a href="#" data-toggle="modal" data-target="#modalPassword">Registrar cuenta</a></small>
                            </div>
                        </form>
                    </li>
                </ul></li>
            </ul>
        </nav>
        
        <div id="modalPassword" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Registro</h3>
                        <button type="button" class="close font-weight-light" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form class="form" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <div class="modal-body">
                            <p>Nombre: <input type="text" name="nombre" required> </p>
                            <p>Cuenta: <input type="text" name="cuenta" required> </p>
                            <p>Correo: <input type="email" name="email" required> </p>
                            
                            <p>Pregunta de seguridad:
                                <select name="pregunta" id="pregunta" onchange="mostrarCampoRespuesta()">
                                    <option value="" selected disabled>Selecciona una pregunta</option>
                                    <option value="mascota">¿Cuál es tu mascota favorita?</option>
                                    <option value="deporte">¿Cuál es tu deporte favorito?</option>
                                    <option value="apodo">¿Cuál era tu apodo de pequeñ@?</option>
                                    <option value="heroe">¿Quién era el héroe de tu infancia?</option>
                                    <option value="amigo">¿Cuál es el nombre de tu mejor amigo?</option>
                                    <option value="vacaciones">¿Dónde fuiste de vacaciones el año pasado?</option>
                                </select>
                            </p>
                            <p id="campoRespuesta" class="oculto">Respuesta: <input type="text" name="respuesta" required></p>
                        
                            <p>Contraseña: <input type="password" id="password" name="contra" required oninput="validarContrasenas()"> </p>
                            <p>Repetir contraseña: <input type="password" id="confirmPassword" required oninput="validarContrasenas()"> </p>
                            <h6 id="mensajeError" style="color:red;"></h6>
                        
                        </div>
                        <div class="modal-footer">                
                            <div class="form-group">                  
                                <button type="submit" id="submitButton" name="submit" class="btn btn-primary btn-block" disabled>Enviar</button>
                           </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="hh"></div>




        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <!-- Este Script lo que hace es limpiar los campos del formulario cuando la ventana del modal se cierre  -->
        <script>
            $(document).ready(function(){
            $('#modalPassword').on('hidden.bs.modal', function () {
                $(this).find('input[type=text], input[type=email], input[type=password], select').val(''); //Limpia cada campo
                $('#mensajeError').text(''); //Limpia el mensaje de error
                $('#campoRespuesta').addClass('oculto'); //Oculta el campo respuesta al limpiar el formulario
            });
            });
        </script> 
    </body>
</html>




  