<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/includes/funciones.php");

inicio_html("Fechas en PHP", ['../styles/formulario.css', '../styles/general.css']);

echo "<h1>Fechas en php</h1>";

    /*

    Fechas en PHP
    -------------

    Para gestionar fechas en PHP:

    - Clase DateTime -> Almacena y gestiona una fecha y hora.
    - Clase DateInterval -> Almacena y gestiona un intervalo de tiempo.
    - Clase DatePeriod -> Almacena y gestiona un periodo de tiempo.
    */

    $mi_fecha_de_nacimiento = new DateTime();

    // Fecha y hora actual en UTC.
    $formato_fecha ="j/n/Y G:i:s";
    echo "<p>Hora y fecha actual UTC " . $mi_fecha_de_nacimiento->format($formato_fecha) . "</p>";

    // Fecha y hora actual en España.
    $mi_fecha_de_nacimiento = new DateTime('',new DateTimeZone("Europe/madrid"));
    echo "<p>Hora y fecha actual " . $mi_fecha_de_nacimiento->format($formato_fecha) . "</p>";

    // Poner por defecto ola zona horaria.
    date_default_timezone_set("Europe/Madrid");
    ini_set("date.timezone", "Europe/Madrid");

    // Fecha y hora actual en la zona horaria modificada.
    $mi_fecha_de_nacimiento = new DateTime();
    echo "<p>Hora y fecha actual " . $mi_fecha_de_nacimiento->format($formato_fecha) . "</p>";

    // Indicar una fecha concreta en el objeto DateTime.
    // 24 febrero
    $mi_fecha_de_nacimiento = new DateTime("2/24");
    echo "<p>Hora y fecha actual " . $mi_fecha_de_nacimiento->format($formato_fecha) . "</p>";

    // 31 octubre 2012.
    $mi_fecha_de_nacimiento = new DateTime("31.10.2012");
    echo "<p>Hora y fecha actual " . $mi_fecha_de_nacimiento->format($formato_fecha) . "</p>";

    // 26 de noviembre de 1985.
    $mi_fecha_de_nacimiento = new DateTime("1985");
    echo "<p>Hora y fecha actual " . $mi_fecha_de_nacimiento->format($formato_fecha) . "</p>";

    // 15 de diciembre de 2024 hora 18:15:20
    // 24 febrero
    $mi_fecha_de_nacimiento = new DateTime("15.12.2024 181520");
    echo "<p>Hora y fecha actual " . $mi_fecha_de_nacimiento->format($formato_fecha) . "</p>";

    ?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <fieldset>
                <legend>Introduce dos datos de fecha</legend>
                <label for="fecha_date">Fecha 1</label>
                <input type="date" name="fecha_date" id="fecha_date">
                <label for="fecha_date">Fecha 2</label>
                <input type="text" name="fecha_text" id="fecha_text" pattern="[0-9]{1-2}/[0-9]{1,2}/[0-9]{4}">
            </fieldset>
            <input type="submit" name="operacion" id="oeracion" value="Enviar">
        </form>
    <?php
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanear los datos introducidos por el usuario.
        $fecha_date = filter_input(INPUT_POST, 'fecha_date', FILTER_SANITIZE_SPECIAL_CHARS);
        $fecha_text = filter_input(INPUT_POST, 'fecha_text', FILTER_SANITIZE_SPECIAL_CHARS);

        // Visualizamos las fechas desde el formulario

        // Validar las fechas.
        try{
            $fecha1 = new DateTime($fecha_date);
            $fecha_text = str_replace("/", ".", $fecha_text);

            $fecha2 = new DateTime($fecha_text);

            echo "<p>Fechas desde el formulario son:</p>";

            echo "Fecha 1: $fecha_date<br>";
            echo "Fecha 2: $fecha2";
        } catch (DateMalformedStringException $e){
            echo "<p>Error al convertir las fechas:</p>";
            echo "Código: " . $e->getCode() . "<br>";
            echo "Mensaje: " . $e->getMessage() . "<br>";

        }
    }


    // Crear fecha con date_create_from_format().
    echo "<h3>Método createFromFormat()</h3>";

    /*

        Método createFromFormat()
        -------------------------

        Campos de fecha y hora.

        -d -> Día con ceros iniciales (2 dígitos).
        -j -> Día sin ceros iniciales.

        -m -> Mes con ceros iniciales (2 dígitos).
        -n -> Mes sin ceros iniciales

        -y -> Año con dos dígitos.
        -Y -> Año con cuatro dígitos.

        -G -> Hora de 0 a 23.
        -i -> Minutos de 00 a 59.
        -s -> Segundos de 00 a 59.

    */

    $formato_sin_ceros = "j/n/Y";
    $mi_fecha_nacimiento = DateTime::createFromFormat($formato_sin_ceros, "20/5/2001");
    echo "<p>Mi fecha de nacimiento es: " . $mi_fecha_nacimiento->format($formato_fecha) . "</p>";

    $formato_con_ceros = "d/m/Y";
    $mi_fecha_nacimiento = DateTime::createFromFormat($formato_con_ceros, "5/3/98");
    echo "<p>Mi fecha de nacimiento es: " . $mi_fecha_nacimiento->format($formato_fecha) . "</p>";

    // Formatear una fecha introducida desde un formulario en tipo texto.
    // Lo mejor es usar el constructor, pero si usamos createFromFormat() hay que
    // verificar que el valor de devolición no es false.
    $formato_esp = "d/m/Y";
    $mi_fecha_nacimiento = DateTime::createFromFormat($formato_esp, $fecha2);
    echo $mi_fecha_nacimiento ? 'Es falso' : $mi_fecha_nacimiento;


    /*
        Modificar un valor de fecha/hora
        --------------------------------

        Métodos setDate() y setTime().

        Permiten modificar la fecha completa y la hora completa respectivamente.

    */

    // Método setDate(). Modifico todos los campos
    $mi_fecha_nacimiento = DateTime::createFromFormat($formato_esp, "23/8/2000");
    $mi_fecha_nacimiento->setDate(1997, 9, 3);

    echo "<p>Mi fecha de nacimiento es: " . " $mi_fecha_nacimient->format($formato_fecha) ".  "</p>";


    

?>



<?php

fin_html();

?>