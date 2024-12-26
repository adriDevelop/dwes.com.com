<?php

try{
    spl_autoload_register("autocarga_clases");
}catch(Exception $e){
    echo "<h3>Error en la carfa de una clase:</h3> $e";
    exit(1);
};

define("DIRECTORIO_CLASES", __DIR__);
function autocarga_clases(string $clase): void{
    /*
        El argumento $clase tiene el nombre de la clase que PHP está instanciando. Por tanto 
        necesita el archcivo PHP que contiene su definición.

        Si la clase tiene asignado espacio de nombres, el nombre de la clase contiene su 
        espacio de nombres.
    */
    $clase = str_replace("\\", "/", $clase);
    if (file_exists(DIRECTORIO_CLASES . "/$clase.php")){ 
        require_once(DIRECTORIO_CLASES ."/$clase.php");
    } else {
        throw new Exception("El archivo de la clase $clase no existe");
    }
    
}

use ra6\bbdd\Usuario as Usuario;
use ra6\poo\Empleado as Empleado;

require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/includes/funciones.php");

inicio_html("Ejercicio espacio de nombres", ['../../styles/general.css']);

$usu1 = new Usuario("pepe", "José García", "Adm");

$emp1 = new Empleado("31016821X", "Caitlyn");

echo "$usu1<br>";
echo "$emp1<br>";

fin_html();

?>