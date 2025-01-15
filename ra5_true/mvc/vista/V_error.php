<?php
namespace mvc\vista;
require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/ra5_true/mvc/vista/Vista.php");
use mvc\vista\Vista;
use Exception;


class V_error extends Vista{
   public function genera_salida(mixed $datos): void
   {
    echo "<h1>Error: {$datos->getMessage()}</h1>";
   }
}

?>