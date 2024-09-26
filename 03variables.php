<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tipos de datos</title>
    </head>
    <body>
        <h1>Variables: 03variables</h1>
        <?php
        // Las variables se definen con $identificador
        $nombre_variable = "Valor de la variable";

        // Variables que no se han definido
        $resultado = $numero + 25;
        echo "El valor de numero es $numero y el resultado es $resultado<br>";

        $resultado = $sin_definir + 5.5;
        echo "El valor de sin definir es $sin_definir y el resultado es $resultdado<br>"

        // Si la variable está en un contexto lógico su valor
        // lógico asume por defecto False


        ?>

        <h2>Análisis de variables</h2>
        <h3>Análisis simple</h3>
        <?php
            // Consiste en introducir una variable en una cadena con " o heredoc
            // para incrustar su valor dentro de la cadena.
            echo "El resutado es $resultado<br>"

        ?>

        <h3>Análisis complejo</h3>
        <?php
            // En algunas situaciones noso encontramos ambigüedad en
            // una variable interpolada. Para ello usamos las llaves
            // y se elimina la ambigüedad.
            $calle = "Trafalgar Sq";
            $numero = 5;
            $poblacion = "London";
            $distrito = "5000";

            echo "Mi dirección en Londres es:<br> {$numero}th, $calle<br>$poblacion<br>$distrito<br>";
        ?>

        <h2>Funciones para variables</h2>
        <?php
            // Función gettype()
            echo "El tipo de datos de $resultado es " . gettype($resultado) . "<br>";
            echo "El tipo de datos de una expresión es " . gettype($numero) . "<br>";

            // Función empty()
            /*
             Comprueba si una variable tiene un valor 
             - Si es entero devuelve True si es 0, False en caso contrario.
             - Si es float devuelve True si es 0.0, False en caso contrario.
             - Si es cadena devuelve True si es "", False en caso contrario.
             - Devuelve True si es NULL o False.
            */
            if( empty($numero) ) echo "\$numero tiene el valor $numero<br>";
            else echo "\$numero tiene un valor no vacío<br>";

            $numero = NULL;
            if( empty($numero) ) $numero = 10;
            else echo "\$numero ya tiene un valor asignado y es $numero<br>";

            // Función isset()
            // Devuelve True si la variable está definida y no es NULL
            if( isset($nueva_variable)) echo "La variable está definida y su valor es $nueva_variable<br>";
            else echo "La variabe no está definida<br>";

            $variable_null = NULL;
            if( isset($variable_null)) echo "La variable está definida y su valor es $variable_null<br>";
            else echo "La variabe no está definida<br>";

            /*
            Funciones que comprueban los tipos de datos:

                - is_bool() -> True si la expresión es booleana
                - is_int() -> True si la expresión es integer
                - is_float() -> True si lal expresión es float
                - is_string() -> True si la expresión es una cadena
                - is_array() -> True si la expresión es un array

                En cualquier otro caso, develve false.
            */

            $edad = 25;
            $mayor_edad = $edad > 18;
            $numero_e = 2.71;
            $mensaje = "El número e es " . $numero_e . "<br>";

            if( is_int($edad) ) echo "\$numero es un entero<br>";
            if( is_bool($mayor_edad) ) echo "\$mayor_edad es un boolean<br>";
            if( is_float($numero_e) ) echo "\$numero_e es un float<br>";
            if( is_string($mensaje) ) echo "\$mensaje es un string<br>";
        

        ?>
        <h2>Constantes</h2>
        <p>Una constante es un valor con nombre que no puede cambiar de valor en el programa, se le asigna un valor en la declaracióny permanece invariable.
            Se definen de dos formas:<br>
            - Mediante la funcion define()<br>
            - Mediante la palabra clave const
        </p>
        <?php
            define("PI", 3.1416);
            define("PRECIO_BASE", 1500);
            define("DIRECTORIO_SUBIDAS", "/uploads/archivos");

            echo "El número pi es " . PI . "<br>";
            $area_circulo = PI * PI * 5;
            echo "El área del círculo de radio 5 es $area_circulo<br>";

            $path_archivo = DIRECTORIO_SUBIDAS . "/archivo.pdf";
            echo "El archivo subido es $path_archivo<br>";

            $precio_rebajado = PRECIO_BASE - PRECIO_BASE * 0.25;
            echo "El precio rebajado es $precio_rebajado<br>";

            const SESION_USUARIO = 600;
            echo "La sesión de usuario finaliza en " . SESION_USUARIO . " segundos<br>";

            // Constantes predefinidas por PHP
            echo "El script es " . __FILE__ . " y la línea es " . __LINE__ ."<br>";

        ?>

        <h2>Expresiones, operadores y operandos</h2>
        <p>Una expresión es una combinación de operandos y operadores que arroja un
          resultado. Tiene tipos de datos, que depende del tipo de datos de sus
          operandos y de la operación realizada.<br>
          Un operador es un símbolo formado por uno, dos o tres caracteres que date_interval_formatuna operación.<br>
          Los operadores pueden ser:<bt>
            - Unarios. Solo necesitan un operando.
            - Binarios. Utilizan dos operandos.
            - Ternarios. Utilizan tres operandos.
          Un operando es una expresión en sí misma, siendo la más simple un literal o una variable, pero tambiñen puede ser un valor devuelto por una función o
          la precedencia y asociatividad de los operadores. Esta puede alterar a
          conveniencia.
        </p>
        <h2>Operadores</h2>
        <h3>Asignación</h3>
        <?php
          // El operador de asignación es = 
          $numero = 45;
          $resultado = $numero + 5 - 29;
          $sin_valor = NULL;


        ?>
        <h3>Operadores aritméticos</h3>
        <?php
          /*
            + Suma
            - Resta
            * Multiplicación
            / División
            % Módulo
            ** Exponenciación

            Unarios
            + Conversión a entero
            - El opuesto
          */
          $numero1 = 15;
          $numero2 = 18;
          $suma = $numero1 + 10;
          $resta = 25 - $numero2;
          $opuesto = -$numero1;
          $multiplicacion = $numero1 * 3;
          $division = $numero2 /3;
          $modulo = $numero1 % 4;
          $potencia = $numero1 ** 2;
          echo "Suma: $suma<br>";
          echo "Resta: $resta<br>";
          echo "Opuesto: $opuesto<br>";
          echo "Multiplicación: $multiplicacion<br>";
          echo "Divisón: $division<br>";
          echo "Módulo: $modulo<br>";
          echo "Potencia: $potencia<br>";

          $numero3 = "35";
          $numero4 = +$numero3;
          echo "El \$numero4 y su tipo es " . gettype($numero4) . "<br>";

          // No lo hace con float
          $numero5 = PI;
          $numero6 = +$numero5;
          echo "El \$numero6 es $numero6 y su tipo es " . gettype($numero6) . "<br>";
          ?>


    </body>
</html>