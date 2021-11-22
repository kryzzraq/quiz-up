<?php
session_start();

function guardarPreguntas(){
    if(isset($_REQUEST['pregunta'])) {
        //guardamos la info de la pregunta y la respuesta enviada por formulario
        $pregunta = $_REQUEST['pregunta'];
        $respuestaA = $_REQUEST['respuestaA'];
        $respuestaB = $_REQUEST['respuestaB'];
        $respuestaC = $_REQUEST['respuestaC'];
        $respuestaD = $_REQUEST['respuestaD'];
        $respuestaCorrecta = $_REQUEST['correcta'];

        //abrimos el archivo en modo lectura y escritura
        $file = fopen("file/preguntas.csv", "a");
        //si se ha abierto...:
        if ($file) {
            //escribimos la pregunta y las respuestas:
            fwrite($file,"$pregunta:$respuestaA:$respuestaB:$respuestaC:$respuestaD:$respuestaCorrecta\n");
            //cerramos el archivo
            fclose($file);
            echo "Pregunta guardada correctamente.";
        }
    }
}

function cargarPreguntasAlArray(){
    $_SESSION['usuario'] = $_REQUEST['usuario'];
    $i=0;
    $_SESSION['preguntas'] = [];

    //abro el archivo de preguntas
    $archivoPreguntas = fopen("file/preguntas.csv","r");

    //mientras que no haya acabado el archivo
    while(!feof($archivoPreguntas)){
        //cargo en el array de [i] las preguntas
        $_SESSION['preguntas'][$i] = explode(":",fgets($archivoPreguntas));
        //elimino el salto de línea de la última posición del array si existe. Si no hacía esto, en la último caracter
        // de la posición del array, también me guardaba un salto de línea y no se visualizaba de manera correcta.
        if(isset($_SESSION['preguntas'][$i][5]))
            $_SESSION['preguntas'][$i][5] = trim($_SESSION['preguntas'][$i][5]);
        //le sumamos 1 a $i para que siga cargando las preguntas
        $i++;
    }
    //Al guardar guardar las preguntas, el último caracter es un salto de línea, por lo tanto al cargar las
    //líneas del fichero en un array, también se carga la línea vacía en la última posición. Mi solución
    //para que a la hora de barajar las preguntas no se me quede una posición vacía en el array es eliminarla.
    unset($_SESSION['preguntas'][count($_SESSION['preguntas'])-1]);

    //mezclo las preguntas
    //al hacer un shuffle me reordena los índices y además comienza desde 0
    shuffle($_SESSION['preguntas']);
}

function jugar(){
    if(isset($_SESSION['respuesta'])) {
        unset($_SESSION['respuesta']);
        unset($_REQUEST['respuesta']);
    }
    $_SESSION['boolAcertada'] = true;
    //creo un formulario que tenga una pregunta y 4 respuestas
    echo "
            <form name='pregunta' method='post' action='juego.php'>
                <div>{$_SESSION['preguntas'][0][0]}</div>
                <button value='A' name='respuesta' onclick='submit()'>{$_SESSION['preguntas'][0][1]}</button>
                <button value='B' name='respuesta' onclick='submit()'>{$_SESSION['preguntas'][0][2]}</button>
                <button value='C' name='respuesta' onclick='submit()'>{$_SESSION['preguntas'][0][3]}</button>
                <button value='D' name='respuesta' onclick='submit()'>{$_SESSION['preguntas'][0][4]}</button>
            </form>
        ";
}

function comparar(){
    $_SESSION['respuesta'] = $_REQUEST['respuesta'];

    #si el campo 5 del array es igual al request que ha enviado el usuario añado los puntos
    #y los modifico
    if ($_SESSION['preguntas'][0][5] === $_SESSION['respuesta']) {

            $_SESSION['puntos_usu'] += $_SESSION['puntos'];
            $_SESSION['puntos'] = $_SESSION['puntos']*2;
    } else {
        #si no coinciden las respuestas mando un false para salir del juego
        $_SESSION['boolAcertada'] = false;
    }
}

function borrar(){
    //Elimino la pregunta que acabo de usar
    unset($_SESSION['preguntas'][0]);
    //Barajeo de nuevo las preguntas
    shuffle($_SESSION['preguntas']);
}

function cargarPuntos()
{
    $arrayRecords = [];
    #abro el fichero para lectura y escritura
    $file = fopen("file/records.csv", "r+");
    $i = 0;
    #mientras que el fichero no se haya acabado...
    if ($file) {
        while (!feof($file)) {
            $arrayRecords[$i] = explode(":", fgets($file));
            if (isset($arrayRecords[$i][1])) {
                $arrayRecords[$i][1] = trim($arrayRecords[$i][1]);
            }
            $i++;
        }
        #La última linea del archivo está vacía por el salto de linea de guardar los datos
        # asi que si existe la elimino
        if (isset($arrayRecords[count($arrayRecords) - 1]))
            unset($arrayRecords[count($arrayRecords) - 1]);

        fclose($file);

        return $arrayRecords;
    }
}
function actualizarPuntos($array,$i){
    #Guardo los puntos del usuario actual
    $array[$i][0] = $_SESSION['puntos_usu'];
    $array[$i][1] = $_SESSION['usuario'];

    #abro de nuevo el archivo
    $file2 = fopen("file/records.csv","w");
    if ($file2) {
        rsort($array);
        for($i = 0; $i<5; $i++){
            if(isset($array[$i])) {
                fwrite($file2, "{$array[$i][0]}:{$array[$i][1]}\n");
            }
        }
        //cerramos el archivo
        fclose($file2);
    }


}
function pintarTabla($array){
    foreach ($array as $indice){
        foreach ($indice as $clave){
            echo $clave ."  ";
        }
        echo "<br/>";
    }
}

