<?php

ob_start();

/*

    BBDD en PHP
    -----------

    - Extensión MYSQLi -> Solo para bbdd mysql. Es la librería estandar que usa PHP para acceder a una base de datos mysql.

    - Extensión PDO -> Para cualquier bbdd. Si uso sql estándar, puedo emplear cualquier SGBD (MySQL, Oracle, Microsoft SQL Server, PostgreSQL...) Además
                       puedo migrar la BD de un SGBD a otro solamente cambiando una línea de código en la aplicación.
    
    - Cualquier sentencia SQL: 
        - DML: SELECT, INSERT, UPDATE, DELETE.
        - DDL: CREATE TABLE, CREATE VIEW, ...
        - DCL: CREATE USER, ALTER USER, GRANT, REVOKE,...

    - Pasos para acceder a una BBDD: 
        - Establecer la conexión.
            - Consiste en crear un canal de comunicación entre la aplicación o entre el SGBD.
            - La aplicación envia sentencias de SQL y el SGBD devuelve el resultado.
        
        Se necesita: servidor (dirección IP o nombre DNS), puerto, usuario y clave. Opcionalmente: El esquema o la bbdd a la que se conecta el usuario.

        - Ejecutar una consulta.
            - Una consulta simple: 
            - Una consulta preparada:

        - Recoger los resultados.
            - Si es un SELECT un ResultSet.
            - Si es INSERT, DELETE o UPDATE, el número de filas afectadas por la sentencia.

        - Si hay un error, lo más habitual de sintaxis SQL, se levanta una excepción mysqli_sql_exception.

*/

    require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/includes/funciones.php");


    inicio_html("Consultas simples con MSQLi", ['../../styles/general.css', '../../styles/tablas.css']);
    echo "<header>Consultas simples</header>";

    // Parámetros para abrir conexión con la base de datos
    $servidor = "mysql";
    $puerto = 3306;
    $usuario = "usuario";
    $clave = "usuario";
    $schema = "tiendaol";

    try{
        // Crear la conexión con la BBDD
        $cbd = new mysqli($servidor, $usuario, $clave, $schema, $puerto);

        // Creamos una instancia del controlador de la bbdd.
        /*
            El controlador es un objeto de la clase mysqliDriver.

            Esta clase la usamos para saber como nos tiene que mostrar los errores.
        */
        $controlador = new mysqli_driver();
        $controlador->report_mode = MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR;  // Si se produce un error, dispara un error | Si se produce un warning, dispara un error.

        // Ejecutar una consulta
        $consulta = "SELECT * FROM cliente";

        $resultset = $cbd->query($consulta); // Nos devuelve un conjunto de resultados. RESULTSET. Objeto de la clase MYSQLIRESULTSET.

        // Enviar a la salida del usuario.
        // Recuperamos los datos.
        // 1ª Forma: Copiamos todas las filas en un array escalar o asociativo.

        /*
        $filas = $resultset->fetch_all(MYSQLI_ASSOC); // Devuelve un array asociativo
        echo "<table><thead><tr><th>Nif</th><th>Nombre</th><th>Email</th><th>IBAN</th><th>TLF</th><th>Ventas</th></tr></thead></table>";
        echo "<tbody>";
        foreach($filas as $fila){
            echo "<tr>";
            echo "<td>{$fila['nif']}</td>";
            echo "<td>{$fila['nombre']} {$fila['apellidos']}</td>";
            echo "<td>{$fila['email']}</td>";
            echo "<td>{$fila['iban']}</td>";
            echo "<td>{$fila['telefono']}</td>";
            echo "<td>{$fila['ventas']}€</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
        echo "<p>¿Cuántos registros ha habido? . " . $resultset->num_rows . "</p>";

        */

        // 2ª Forma: Acceder a los datos fila a fila.
        echo "<table><thead><tr><th>Nif</th><th>Nombre</th><th>Email</th><th>IBAN</th><th>TLF</th><th>Ventas</th></tr></thead>";
        echo "<tbody>";
        while($fila = $resultset->fetch_assoc()){
            echo "<tr>";
            echo "<td>{$fila['nif']}</td>";
            echo "<td>{$fila['nombre']} {$fila['apellidos']}</td>";
            echo "<td>{$fila['email']}</td>";
            echo "<td>{$fila['iban']}</td>";
            echo "<td>{$fila['telefono']}</td>";
            echo "<td>{$fila['ventas']}€</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
        echo "<p>¿Cuántos registros ha habido? . " . $resultset->num_rows . "</p>";

        // Libero los recursos del resultset.
        $resultset->close();

    } catch(mysqli_sql_exception $e){

        echo "<h3>Error de base de datos en la aplicación.</h3>";
        echo "<h3>Código de error: " . $e->getCode() . "</h3>";
        echo "<p>Mensaje: " . $e->getMessage()  . "</p>";
        echo "<p>Archivo:  " . $e->getFile() . " </p>";
        echo "<p>Linea: " . $e->getLine() . "</p>";

    } finally {
        if (!$cbd){
            
        }
        $cbd->close();
    }

    $ob_content = ob_get_contents();
    ob_flush();

    fin_html();


?>