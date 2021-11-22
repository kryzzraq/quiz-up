<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <LINK rel="stylesheet" href="estilos/style.css" type="text/css">
</head>
<body>
<div id="contenedor">
    <span>Quiz-up!</span>
    <?php
    require_once("funciones.php");

    //Si no ha insertado el nombre de usuario lo pido y recojo
        if(!isset($_SESSION['usuario']) && !isset($_REQUEST['usuario'])){
    ?>
        <div id="contenido4" class="usuario">
            <form action="juego.php" method="post" name="nombre">
                <label for="nombre">Ingresa tu nombre de usuario:</label>
                <input id="respuesta" type="text" name="usuario" id="usuario" required="required"><br/>
                <input id="botones" type="submit" value="¡Jugar!">
            </form><br/>
            <a href="index.php"><button name="volver" value="volver">Volver</button></a>
        </div>
    <?php
        //si ya está insertado
        } else {
            //guardo el nombre de usuario, inicializo los puntos
            //cargo las preguntas al array
            if(isset($_REQUEST['usuario'])){
                $_SESSION['usuario'] = $_REQUEST['usuario'];
                $_SESSION['boolAcertada'] = true;
                $_SESSION['puntos'] = 10;
                $_SESSION['puntos_usu'] = 0;
                cargarPreguntasAlArray();
            }

            //si la respuesta esta seleccionada y el array no está vacio comparo para saber si ha
            //acertado y después elimino la pregunta
            if(isset($_REQUEST['respuesta']) && !empty($_SESSION['preguntas'])){
                comparar();
                borrar();
            }
            if(empty($_SESSION['preguntas'])){
                $_SESSION['puntos_usu'] += 1000;
            }

            if(isset($_SESSION['usuario'])){
                ?>
                <div id="usuario">
                    <?php
                    echo "<span id='usu'>Usuario: {$_SESSION['usuario']}</span>  <br/>
                    <span id='usu'>Puntuación: {$_SESSION['puntos_usu']}</span>";
                    ?>
                </div>
                <?php
            }
            //Después juego mientras no haya fallado y el array no esté vacío
            if(isset($_SESSION['usuario']) && !empty($_SESSION['preguntas']) && $_SESSION['boolAcertada']){
                ?>
                <div id="contenido2">
                     <?php jugar(); ?>
                </div>
                <?php
            } else{
                //cargar el array de puntuaciones dividido en nombre:puntos
                $arrayPuntos = cargarPuntos();
                actualizarPuntos($arrayPuntos,count($arrayPuntos));
                ?>
                <div id="contenido2">
                    <?php
                        echo "Fin del juego, su puntuación ha sido {$_SESSION['puntos_usu']}<br/>
                        <a href='index.php'><button name='volver' value='volver'>Volver</button></a>";
                    ?>
                </div>
                    <?php
            }
        }


    ?>
</div>
</body>
</html>