<?php

use ra6\poo\Empleado;

    require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/includes/funciones.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/ra5/poo/Emp.php");

    inicio_html("Información de clases", ['../styles/styles.css']);

    /*
        Funciones útiles para obtener información de clases
        ---------------------------------------------------

        - is_objetct($var) -> True si $var es un objeto.
        - gettype($var) -> Si $var es un objeto devuelve object
        - get_class($var) -> Devuelve la clase de $var

        - El nombre de la clase lo puede obtener:
            - $objeto::class
            - self::class -> dentro de la clase.
            - __CLASS__ -> constante mágica.
            - nombre_clase::class

        - property_exist($clase | $objeto, $propiedad) -> True si $propiedad es una propiedad
                                                          de la clase $clase o del objeto 
                                                          $objeto.
        
        - method_exist($clase | $objeto, $metodo) -> True si $metodo es un método de la clase $clase
                                                     o método del objeto $objeto.

        - $objeto instanceof $clase -> True si $objeto es 
    */
    require_once("06Piso.php");

    $p = new Piso("aaa000", "C/Mayor, 3", 80, 3, "A");

    echo "<header>Informacióin de clases</header>";
    echo "<p>Es \$p un objeto: " . (is_object($p) ? "Si" : "No") . "</p>";

    $numero = 3;
    echo "<p>Es \$numero un objeto: " . (is_object($numero) ? "Si" : "No") . "</p>";

    echo "<p>El tipo de \$p es " . gettype($p) . "</p>";

    if (is_object($p)){
        echo "<p>La clase de \$p es " . get_class($p) . "</p>";
    }

    if (property_exists($p::class, "planta") && property_exists($p, "planta") && property_exists(Piso::class, "planta")){
        echo "<p>La planta es una propiedad de piso</p>";
    } else {
        echo "<p>La planta no es una propiedad de piso</p>";
    }

    if (method_exists($p::class, "getValorEstimado") && method_exists($p, "getValorEstimado") && method_exists(Piso::class, "getValorEstimado")){
        echo "<p>El método getValorEstimado es de Piso</p>";
    } else {
        echo "<p>El método getValorEstimado es de Piso</p>";
    }

    if ( $p instanceof Piso){
        echo "<p>\$p es instancia de Piso</p>";
    }

    if ($p instanceof Vivienda){
        echo "<p>\$p es instancia de Vivienda</p>";
    }

    $emp = new Emp("30000001A", password_hash("usuario", PASSWORD_DEFAULT), "pepe");

    if ($emp instanceof GestionSeguridad){
        echo "<p>\$emp es instancia de Gestión seguridad</p>";
    } else {
        echo "<p>\$emp no es instancia de Gestión Seguridad</p>";
    }

    fin_html();

?>