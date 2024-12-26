<?php


require_once($_SERVER['DOCUMENT_ROOT'] . "/ejercicio1_mantenimiento_estado/includes/functions.php");

/*

    Consultas preparadas
    --------------------

    Ponemos los datos en un formulario.

    Recogemos los datos que hayan enviado.

    Creamos la cadena con la cláusula WHERE.

    Creamos la consulta preparada.

    Vinculamos los datos.

    Ejecutar la consulta.

    Procesar los resultados.

*/



    inicio_html("Consultas simples con mysqli", ['../../styles/general.css', '../../styles/tablas.css']);
    // Parámetros para abrir conexión con la base de datos
    $servidor = "mysql";
    $puerto = 3306;
    $usuario = "usuario";
    $clave = "usuario";
    $schema = "tiendaol";
    ?>

    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <fieldset>
            <legend>Criterios de búsqueda</legend>
            <label for="referencia">Referencia</label>
            <input type="text" name="referencia" id="referencia">
            <label for="descripcion">Descripción</label>
            <input type="text" name="descripcion" id="descripcion">
            <label for="pvp">PVP</label>
            <input type="text" name="pvp" id="pvp">
            <label for="categoria">Categorias</label>
            <input type="text" name="categoria" id="categoria">
            <input type="submit" name="operacion" id="operacion">
        </fieldset>
    </form>

    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Usaremos arrays para validar todos los datos.
        // Los datos que no hayan sido validados los eliminaremos.
        // Nos quedaremos solo con los datos que si que hayan sido validados.

        // Filtros de saneamiento
        $filtros_saneamiento = ["referencia" => FILTER_SANITIZE_SPECIAL_CHARS,
                                "descripcion" => FILTER_SANITIZE_SPECIAL_CHARS,
                                "pvp" => ['filter' => FILTER_SANITIZE_NUMBER_FLOAT,
                                          'flags' => FILTER_FLAG_ALLOW_FRACTION],
                                "categoria" => FILTER_SANITIZE_SPECIAL_CHARS,
        ];

        // Datos saneados
        $datos_saneados = filter_input_array(INPUT_POST, $filtros_saneamiento, false);

        // Filtros
        $filtros_validacion = ['referencia' => FILTER_DEFAULT,
                               'descripcion' => FILTER_DEFAULT,
                               'precio' => ['filter' => FILTER_VALIDATE_FLOAT,
                                            'options' => ['min_range' => 1],
                                            ],
                             ];
        
        $datos_validados = filter_var_array($datos_saneados, $filtros_validacion);

        // Esta función le pasamos una array y una función.
        // Esa función se va a ejecutar por cada elemento del array y los que no contengan valores,
        // se eliminan.

        // Por defecto, lo hace automaticamente comprobando si es true o false (relleno o no relleno), por
        // lo tanto, no hace falta que creemos la función y se la pasemos.
        array_filter($datos_validados);
    }

    try{
        // Genero la conexión
        $conexion = new mysqli($servidor, $usuario, $clave, $schema, $puerto);
        // Genero la consulta preparada
        $sentencia = "SELECT referencia, descripcion, pvp, und_vendidas ";
        $sentencia.= "FROM articulo ";

        if ($clausula_where){
            $sentencia.= $clausula_where;
        }

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
        $smtm->bind_param($tipos_datos, $pvp_minimo, $categoria, $und_vendidas);

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