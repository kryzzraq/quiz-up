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
<?php require_once("funciones.php") ?>
<div id="contenedor">

    <span>Guardar preguntas:</span>
        <div id="contenido1">
    <!-- cargo la funcion guardar preguntas -->
    <?php guardarPreguntas(); ?>
    <form action="editarpreguntas.php" name="editar" method="post">
        <div id="dFrm">
            <label for="pregunta">Pregunta:</label>
            <input type="text" name="pregunta" id="pregunta" required="required">
        </div>
        <div id="dFrm">
            <label for="respuestaA">Respuesta A:</label>
            <input type="text" name="respuestaA" id="respuesta" required="required">
        </div>
        <div id="dFrm">
            <label for="respuestaB">Respuesta B:</label>
            <input type="text" name="respuestaB" id="respuesta" required="required">
        </div>
        <div id="dFrm">
            <label for="respuestaC">Respuesta C:</label>
            <input type="text" name="respuestaC" id="respuesta" required="required">
        </div>
        <div id="dFrm">
            <label for="respuestaD">Respuesta D:</label>
            <input type="text" name="respuestaD" id="respuesta" required="required">
        </div>
        <div id="dFrm">
            <label for="correcta">Respuesta correcta:</label>
            <select name="correcta" id="correcta">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        </div>
        <div id="dFrm">
            <input id="botones" type="submit" value="Guardar pregunta">
            <input id="botones" type="reset" value="Borrar">
        </div>
        <div>

    </form>

    </div>
    <a href="index.php"><button name="jugar" value="jugar">Volver</button></a>
</div>
</body>
</html>