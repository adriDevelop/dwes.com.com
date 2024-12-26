<?php


require_once($_SERVER['DOCUMENT_ROOT'] . "/ejercicio1_mantenimiento_estado/includes/functions.php");

/*

    Consultas preparadas
    --------------------

    Cuando en una sentencia SQL necesitamos usar datos que ha generado la propia apliación: 
        -Procedentes de un formulario del usuario
        -Creados o calculados por la aplicación
        ...

    Son datos que no podemos poner directamente en la consulta SQL.

    En su lugar se ponen parámetros y cuandos e ejecuta la sentencia, se vinculan los parámetros con los datos necesarios.

    El proceso sería:
        -Crear la coneción a la BD.
        -Crear una consulta preparada: objeto de la clase msqli_stmt. Esta se crea indicando la sentencia SQL con parámetros.

        - Se vinculan los valores de los parámetros de la consulta. Estos valores tienen que estas saneados.
        - Se ejecuta la sentencia.
        - Se obtienen los resultados.
        -Se procesan los resultados.

    En la sentencia SQL cada parámetro se indica con ?. 
    Ejemplo:
        - SELECT referencia, descripcion, pvp, ...
          WHERE pvp > ? AMD categoria = ? AND tipo_iva = ?

          INSERT INTO

*/

    inicio_html("Consultas simples con mysqli", ['../../styles/general.css', '../../styles/tablas.css']);
    // Parámetros para abrir conexión con la base de datos
    $servidor = "mysql";
    $puerto = 3306;
    $usuario = "usuario";
    $clave = "usuario";
    $schema = "tiendaol";

    try{
        // Genero la conexión
        $conexion = new mysqli($servidor, $usuario, $clave, $schema, $puerto);
        // Genero la consulta preparada
        $sentencia = "SELECT referencia, descripcion, pvp, und_vendidas ";
        $sentencia.= "FROM articulo ";
        $sentencia.= "WHERE pvp > ? AND categoria = ? AND und_vendidas > ?";

        $smtm = $conexion->prepare($sentencia); // Objeto msqli_stmt;

        // Vinculamos los parámetros de búsqueda.
        $pvp_minimo = 4.75;
        $categoria = "CARN";
        $und_vendidas = 5;

        $categoria = $conexion->escape_string($categoria);

        // Vinculamos los valores a los parámetros
        // Tipo de datos: UNA cadena de caracteres que indica el tipo de datos de cada parámetro usando una úniica letra y en el orden en el
        //                que aparecen en la sentencia
        // Los tipos de datos son s -> cadena, i->entero, d->float, s->fecha
        $tipos = "dsi";
        $smtm->bind_param($tipos, $pvp_minimo, $categoria, $und_vendidas);

        // Ejecutar la sentencia.
        $resultado = $smtm->execute(); // Devuelve un boolean.

        // Obtener los resultados
        $resultset = $smtm->get_result(); // Devuelve el objeto de resultset.

        // Procesamos los resultados.
        echo "<table><thead><tr><th>Referencia</th><th>Descripción</th><th>PVP</th><th>Unidades Vendidas</th></tr></thead>";
        echo "<tbody>";
        while($fila = $resultset->fetch_assoc()){
            echo "<tr>";
            echo "<td>{$fila['referencia']}</td>";
            echo "<td>{$fila['descripcion']}</td>";
            echo "<td>{$fila['pvp']}</td>";
            echo "<td>{$fila['und_vendidas']}</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
        echo "<p>¿Cuántos registros ha habido? . " . $resultset->num_rows . "</p>";

        // Libero los recursos del resultset.
        $resultset->close();

    } catch (mysqli_sql_exception $e) {

    } finally{

    }



    fin_html();

?>