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
<?php
require_once("funciones.php");

if(isset($_SESSION['usuario']))  session_destroy();

?>

<div id="contenedor">
    <span>Quiz-up!</span>
    <div id="contenido">
        <div id="tablaRecords">
            <span id="records">Records</span><br/>
            <?php
            $arrayPuntos = cargarPuntos();
            pintarTabla($arrayPuntos);
            ?>
        </div>

        <div id="funcionalidad">
            ¿Qué quieres hacer? <br/><br/>
            <a  href="editarpreguntas.php"><button id="funcion" name="editar" value="editar">Añadir una pregunta</button></a>
            <a  href="juego.php"><button id="funcion" name="jugar" value="jugar">Jugar una partida</button></a>
        </div>
    </div>


</div>
</body>
</html>