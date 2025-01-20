<?php
// Creación del espacio de nombres
namespace mvc\vista;

class V_Main extends Vista{
    public function genera_salida(mixed $datos): void
    {
        $this->inicio_html("Pagina de inicio", ['../styles/general.css', '../styles/tablas.css', '../styles/formulario.css']);
        if (!isset($_COOKIE['jwt'])){
            ?>
            <h2>Tienda online</h2>
            <form method="POST" action="/dwes.com.com/ra5_true/index.php">
                <label for="login">Login</label>
                <input type="text" name="login" id="login" size="10">
                <label for="login">Clave</label>
                <input type="password" name="clave" id="clave" size="10">
                <button type="submit" name="idp" id="idp" value="autenticar">Buscar artículo</button>
            </form>

            <h3>Comience su compra buscando lo que quiera</h3>
            <form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
                <input type="text" name="descripcion" id="descripcion" size="40">
                <button type="submit" name="idp" id="idp" value="buscar">Buscar artículo</button>
            </form>
            <?
        } else {
        ?>

        <hr>

        <h3>Nuestros artículos en oferta hoy</h3>
        <?php
        echo <<<TABLA
            <table>
                <thead>
                    <tr>
                        <th>Referencia</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Descuento</th>
                        <th>Añadir al carrito</th>
                    </tr>
                </thead>
                <tbody>
        TABLA;

        foreach($datos as $articulo_oferta){
            echo "<tr>";
                echo "<td>{$articulo_oferta['referencia']}</td>";
                echo "<td>{$articulo_oferta['descripcion']}</td>";
                echo "<td>{$articulo_oferta['pvp']}</td>";
                echo "<td>" . floatval($articulo_oferta['dto_venta']) * 100 . "</td>";
                echo "<td> <form action='POST' action='{$_SERVER['PHP_SELF']}'><input type='hidden' name='referencia' id='referencia' value='{$articulo_oferta['referencia']}'><button type='submit' name='idp' value='anadir'>Añadir al carrito</button></form></td>";
            echo "</tr>";
        }
        echo "</tbody></table>";


    }
        $this->fin_html();
    }
}
?>