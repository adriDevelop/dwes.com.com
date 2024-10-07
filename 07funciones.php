<?php

/* Funciones en PHP

  Conjunto de sentencias con un nombre asociado
  que se ejecutan a discreción del desarrollador,
  cuando es necesario.

  Invocación o llamada de la función: Sentencia que solicita
  la ejecución de la función, momento en el cual el flujo del programa se desvía a la primera sentencia de la función 
  y comienza su ejecucion.

  Las funciones pueden necesitar datos. Estos datos se les pasa en forma de parámetros o argumentos de la funcióin
  en el momento de la invocación.

  Pueden devolver uno o varios valores al punto de invocación
  que puede posteriormente utilizarse en cualquier expresion.

  Tipos:
  - Internas integradas o predefinidas -> Las propias del lengguaje.
  - Métodos -> funciones de clases de objetos.
  - De usuario -< Las que el desarrollador define.

  3.1 Definición de la función

  - Se puede definir en cualquier parte del script.
  - Tiene una cabecera y un cuerpo
  - Sintaxis:
      function nombre_función( [arg1, arg2, ...]){
        sentencias
      }
        - Nombre: cualquier identificador válido sin $.
        - Lista de parámetros o argumento separados por coma.
        - El cuerpo de la función es el conjunto de sentencias entre {}
*/

function area_triangulo($base, $altura) {
  $area = $base * $altura / 2;
  return $area;
}

function area_triangulo2($base, $altura){
  echo "Dentro de la función: {$base} y {$altura}<br>";

  $area = $base * $altura;

  $base = 10;
  $altura = 20;

  echo "Dentro de la función: {$base} y {$altura}<br>";

  return $area;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Funciones</title>
</head>
<body>
  <?php

    $base = 8;
    $altura = 3;

    $area = area_triangulo($base, $altura);

    // Invocación de la función.
    echo "El triangulo de base {$base} y altura {$altura} tiene como area {$area}<br>";

    // Paso por valor
    $area = area_triangulo2($base, $altura);
    echo "El triángulo con base {$base} y altura {$altura} tiene como area {$area}<br>";



  ?>
</body>
</html>