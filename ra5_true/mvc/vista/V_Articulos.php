<?php
namespace mvc\vista;
use orm\entidad\Articulo;

class V_Articulo extends Vista{
    public function genera_salida(mixed $datos): void {
        $this->inicio_html("Listado de artículos", ['../../styles/general.css', '../../styles/tablas.css']);

        echo <<<TABLA
        <table>
            <thead>
                <tr>
                    <th>Referencia</th>
                    <th>Descripción</th>
                    <th>PVP</th>
                    <th>Dto</th>
                    <th>Und.Vend.</th>
                    <th>Und.Disp</th>
                    <th>Fecha Disp.</th>
                    <th>Categoria</th>
                    <th>Tipo IVA</th>
                </tr>
            </thead>
            <tbody>
        TABLA;

        foreach($datos as $fila){
                echo "<tr>";
                    echo "<td>{$fila->referencia}</td>" . PHP_EOL;
                    echo "<td>{$fila->descripcion}</td>" . PHP_EOL;
                    echo "<td>{$fila->pvp}</td>" . PHP_EOL;
                    echo "<td>" . $fila->descuento*100 . "</td>" . PHP_EOL;
                    echo "<td>{$fila->und_vendidas}</td>" . PHP_EOL;
                    echo "<td>{$fila->und_disponibles}</td>" . PHP_EOL;
                    $fecha_disponible = $fila->fecha_disponible?
                                        $fila->fecha_disponible->format('d/m/Y'):
                                        "";
                    echo "<td>{$fila->$fecha_disponible}</td>" . PHP_EOL;
                    echo "<td>{$fila->categoria}</td>" . PHP_EOL;
                    $tipos_iva = ['N' => 'Normal', 'R' => 'Reducido', 'SR' => 'Super Reducido'];
                    echo "<td>{$tipos_iva[$fila->tipo_iva]}</td>" . PHP_EOL;
                echo "</tr>";
        }

        $this->fin_html();
    }
}
?>