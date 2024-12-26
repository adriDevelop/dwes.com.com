<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/includes/funciones.php");
require_once("06Vivienda.php");
require_once("06Piso.php");
require_once("06Casa.php");

inicio_html("Herencia en PhP", ['../styles/general.css']);

if ($_SERVER['REQUEST_METHOD'] == 'GET'){

    function ver_valor_estimado(Vivienda $v): void{
        $valor_estimado = $v->getValorEstimado(1200);
        echo "Vivienda: $v: Precio estimado: $valor_estimado";
    }

    $v = new Vivienda("aaa001", "c/ Cruz Conde, 24", 100);

    $p = new Piso("bbb002", "Avenida Gran Vía Parque, 31", 50, 4, 1);

    $c = new Casa("ccc003", "Avenida Carlos Mazón, 20", 150, 25, 30);

    echo "Vivienda: $v<br>";
    echo "Piso: $p<br>";
    echo "Casa: $c<br>";


}





?>