<?php

namespace mvc\vista;

use mvc\vista\Vista;

class V_Buscar extends Vista{
    public function genera_salida(mixed $datos): void{
        $this->inicio_html("Inicio de la compra del usuario", ['../styles/general.css', '../styles/tablas.css']);
        ?>
        <h1>El resultado de búsqueda:</h1>
        <h3>Puede realizar otra búsqueda:</h3>
            <form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
                <input type="text" name="descripcion" id="descripcion" size="40">
                <button type="submit" name="idp" id="idp" value="buscar">Buscar artículo</button>
            </form>
        <?php
        echo "<br>";
        echo "<a href=" . $_SERVER['PHP_SELF'] . ">Volver hacia la búsqueda</a>";
        echo "<br>";
        // Los articulos encontrados los devolvemos en formato de tabla
        echo <<<TABLA
            <table>
                <thead>
                    <tr>
                        <th>Referencia</th>
                        <th>Descripcion</th>
                        <th>Pvp</th>
                        <th>Dto venta</th>
                        <th>Unidades vendidas</th>
                        <th>Unidades disponibles</th>
                        <th>Fecha disponible</th>
                        <th>Categoria</th>
                        <th>Tipo iva</th>
                        <th>Añadir al carrito</th>
                    </tr>
                </thead>
            <tbody>
        TABLA;

        foreach($datos as $fila){
            echo "<tr>";
                echo "<td>{$fila['referencia']}</td>";
                echo "<td>{$fila['descripcion']}</td>";
                echo "<td>{$fila['pvp']}</td>";
                echo "<td>{$fila['dto_venta']}</td>";
                echo "<td>{$fila['und_vendidas']}</td>";
                echo "<td>{$fila['und_disponibles']}</td>";
                echo "<td>{$fila['fecha_disponible']}</td>";
                echo "<td>{$fila['categoria']}</td>";
                echo "<td>{$fila['tipo_iva']}</td>";
                echo "<td><form action='/index.php' method='POST'><input type='hidden' id='referencia' name='referencia' value='{$fila['referencia']}'><button type='submit' name='anadir_carrito' id='anadir_carrito'>Añadir al carrito</button></form></td>";
            echo "</tr>";
        }
    }
}
?>