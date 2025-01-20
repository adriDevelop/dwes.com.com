<?php

namespace mvc\vista;

use DateTime;
use mvc\vista\Vista;

class V_Autenticar extends Vista{
public function genera_salida(mixed $datos): void
{
    $this->inicio_html("Inicio de la compra del usuario", ['../styles/general.css', '../styles/tablas.css']);
    // Nombre y apellidos del usuario
    $cliente = $_SESSION['cliente']->nombre . " " . $_SESSION['cliente']->apellidos;
    echo "<h3>Bienvenido $cliente</h3>";

    // Botón de cierre de sesión
    ?>
    <form method="POST" action="/index.php">
            <button type="submit" name="idp" id="idp" value="cerrar_sesion">Cerrar sesión</button>
        </form>
    <?php

    // Los últimos envíos
    echo <<<TABLA
        <table><thead><tr><th>Nº Envío</th><th>Fecha</th><th>Referencia</th><th>Descripción</th><th>Unidades</th><th>Precio</th><th>Descuento</th></tr></thead><tbody>
    TABLA;

    foreach($datos as $fila){
        $fecha = new DateTime($fila['fecha']);
        $fecha = $fecha->format('d-m-Y - H:i:s');
        echo "<tr><td>{$fila['nenvio']}</td><td>$fecha</td><td>{$fila['referencia']}</td><td>{$fila['descripcion']}</td><td>{$fila['precio']}</td></th>";
    }

    // Formulario de búsqueda de artículos
    ?>
    <form method="POST" action="/index.html">
        <label for="descripcion">Descripción</label>
        <input type="text" name="descripcion" id="descripcion" size="40">

        <button type="submit" name="idp" id="idp" value="buscar">Buscar artículos</button>
    </form>
    <?php
}
}

?>