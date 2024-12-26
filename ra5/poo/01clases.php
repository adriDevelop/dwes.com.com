<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/ra5/poo/includes/funciones.php");
    require_once("Empleado.php");

    // Declarar un objeto de la clase Empleado.
    $emp1 = new Empleado("31016821X", 'Adrian', 'Velasco Carrasco', 1200);

    // Acceso a datos (sin constructor.)
    // $emp1-> nif = "31016821X";
    // $emp1-> nombre = "Adrian";
    // $emp1-> apellidos = "Velasco Carrasco";
    // $emp1-> salario = 1200;

    inicio_html("Comenzamos con poo", [""]);
    // Visualizacion de propiedades.
    echo "Empleado nif: {$emp1->nif}, nombre: {$emp1->nombre}, apellidos: {$emp1->apellidos}, salario: {$emp1->salario}";

    // Constantes de la clase.
    echo "<h3>Accedo a las constante de la clase</h3>";
    echo "<p>El % de IRPF es " . Empleado::IRPF . " y de Seguridad Social es " . Empleado::SS . "</p>";
    printf("El porcentaje de IRP es %4.2f y de SS es %4.2f", Empleado::IRPF, Empleado::SS);

    // Compara todos los valores de las propiedades.
    $emp2 = new Empleado('30000000B', 'Maria', 'Lopez Martinez', 3000);
    echo "<h3>Comparacion de valores de las propiedades</h3>";
    if ($emp1 == $emp2){
        echo "<p>Emp1 y Emp2 tienen todas las propiedades iguales</p>";
    } else {
        echo "<p>Emp1 y Emp2 no tienen todas las propiedades iguales</p>";
    }
    // Comparacion objetos. 
    echo "<h3>Comparacion de objetos</h3>";
    if ($emp1 === $emp2){
        echo "<p>Emp1 y Emp2 apuntan a la misma referencia</p>";
    } else {
        echo "<p>Emp1 y Emp2 no apuntan a la misma referencia</p>";
    }
    

    // Iterar con las propiedades del objeto.
    echo "<h3>Iterar con las propiedades del objeto</h3>";
    foreach($emp1 as $propiedad => $valor){
        echo "<p>$propiedad: $valor</p>";
    }

    // Metodos del objeto.
    echo "<h3>Metodos del objeto</h3>";
    $salario_neto = $emp1->getSalarioNeto();
    echo "El salario neto del Emp1 es: $salario_neto";

    // Usando el metodo para comparar objetos con objetos.
    if ($emp1->esIgual($emp2)){
        echo "<p>Son iguales los objetos</p>";
    } else {
        echo "<p>No son iguales los objetos</p>";
    }

    // Objeto como devolucion de un metodo
    $emp6 = $emp1->salarioDuplicado();
    echo "Nombre: {$emp6->nombre} salario: {$emp6->salario}";

    fin_html();
?>