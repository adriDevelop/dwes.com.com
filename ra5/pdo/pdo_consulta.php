<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/includes/funciones.php");

inicio_html("PDO", ['../../styles/general.css', '../../styles/tablas.css']);

$dsn = "mysql:host=mysql;dbname=tiendaol;charset=utf8mb4";
$usuario = "usuario";
$clave = "usuario";
$opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
];

try{
    $pdo = new PDO($dsn, $usuario, $clave, $opciones);

    $stmt = $pdo->query("SELECT nif, nombre, apellidos, email FROM cliente");

    if ($stmt->execute()){
        echo "<h2>Filass {$stmt->rowCount()}</h2>";
        echo "<h3>Resultados de la consulta</h3>";
        echo <<<TABLA
            <table>
                <thead>
                    <tr>
                    <th>NIF</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    </tr>
                </thead>
            <tbody>
        TABLA;
        while ($fila = $stmt->fetch()){
            echo "<tr>";
            echo "<td>{$fila['nif']}</td>";
            echo "<td>{$fila['nombre']}</td>";
            echo "<td>{$fila['email']}</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    }

}catch(PDOException $pdoe){
    echo "{$pdoe->getCode()}<br>";
    echo $pdoe->getMessage();
}finally{

}

?>