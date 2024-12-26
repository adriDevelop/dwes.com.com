<?php

require_once("Emp.php");
require_once("Cliente.php");
require_once("GestionSeguridad.php");

function prueba_interfaz(GestionSeguridad $empl_cli, $clave): bool{
    if ($empl_cli -> autenticar($clave)){
        echo "<p><Empleado autenticado correctamente></p><br>";
        return true;
    } else {
        echo "<p>Empleado no autenticado con éxito</p><br>";
        return false;
    }
}

$emp1 = new Emp('31016821X',  "Adrian", "adrian");

$cli1 = new Cliente('31016822B', "Maria", "1234");

// Comprobamos que se autentican correctamente.
if ($emp1->autenticar("adrian")){
    echo "Empleado autenticado correctamente<br>";
} else{
    echo "Empleado no autenticado con éxito<br>";
}

if ($cli1->autenticar("1234")){
    echo "Cliente autenticado correctamente<br>";
} else{
    echo "Cliente no autenticado con éxito<br>";
}

prueba_interfaz($empl1, "manuel");
prueba_interfaz($cli1, "1234");

?>