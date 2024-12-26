<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/ra5/poo/includes/funciones.php");
require_once('Direccion.php');

inicio_html("02metodos_magicos", [""]);

$dir1 = new Direccion("C/", "Mayor", 3, 2, "A", 4, "B", 28000, "Madrid");
echo "<h3>Sobrecarga de propiedades</h3>";
echo "{$dir1->tipo_via} - {$dir1->nombre_via} - {$dir1->numero}";

echo "<h3>Metodo set. Cambiando valores.</h3>";
$dir1->nombre_via = "nuevo nombre";
echo "{$dir1->tipo_via} - {$dir1->nombre_via} - {$dir1->numero}";

echo "<h3>Usando unset. Quitando definicion o valores de nuestras propiedades</h3>";
// unset($dir1->nombre_via);
// echo "{$dir1->tipo_via} - {$dir1->nombre_via} - {$dir1->numero}";

echo "<h3>Usando toString()</h3>";
echo "{$dir1}";

// Hacemos una copia de un objeto.
$dir3 = clone $dir1;

// Usamos la sobrecarga de métodos con el método set.
echo "<h3>Sobrecarga de métodos</h3>";
$dir1->setTipoVia("Crta");
echo "{$dir1}";

// Usamos wrapper de métodos
$dir1->cambiarVia('Av');
$dir1->cambiarCalle('Carlos III');
echo "{$dir1}";

// Probamos el valor de debugInfo.
var_dump($dir1);

?>