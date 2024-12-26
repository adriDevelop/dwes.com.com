<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/ra5/poo/includes/funciones.php");
require_once("Empleado.php");

inicio_html("Miembros estáticos", ["/estilos/general.css"]);

echo "<header>Miembros estáticos de una clase</header>";
echo "<h3>Accedo a propiedades estáticas de Empleado</h3>";
echo "<p>La retención por IRPF es " . (Empleado::$IRPF * 100) . " %</p>";

$emp1 = new Empleado('31016821X', 'Adrian', 'Velasco Carrasco', 2000);
echo "<p>Las retenciones de {$emp1->nombre} son: " . ($emp1::getPorcentajes()) . " %</p>";

$emp2 = new Empleado('31016822B', 'Maria', 'Lopez Gonzalez', 2000);
$emp1::$IRPF = 0.3;

echo "<p>Las retenciones de {$emp2->nombre} son: " . ($emp2::getPorcentajes()) . " %</p>";

$dentro_de_un_mes = time() + 30 * 24 * 60 * 60;
echo Empleado::getFechaFormato($dentro_de_un_mes);



fin_html();

?>