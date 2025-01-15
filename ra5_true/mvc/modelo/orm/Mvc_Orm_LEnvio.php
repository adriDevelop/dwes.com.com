<?php

namespace orm\mvc\modelo\orm;

use Exception;
use PDO;

class Mvc_Orm_LEnvio {
    protected PDO $pdo;

    public function __construct()
    {
        $dsn = "mysql:host=mysql;dbname=tiendaol;charset=utf8mb4";
        $usuario = "usuario";
        $clave = "usuario";
        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => FALSE
        ];

        $this->pdo = new PDO($dsn, $usuario, $clave, $opciones);

    }

    public function get_envios(string $nif): array{
        $sql = "SELECT nenvio, npedido, nlinea, referencia, descripcion, unidades, precio, dto";
        $sql.= " FROM nenvio inner join envio usin nenvio";
        $sql.= " inner join lpedido using(npedido, nlinea)";
        $sql.= " inner join articulo using(referencia)";
        $sql.= " WHERE nif = :nif";
        $sql.= " order by fecha desc";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":nif", $nif);

        if ($stmt->execute()){
            return $stmt->fetchAll();
        } else {
            throw new Exception("Error al obtener los envíos del cliente", 4004);
        }
    }
}

?>