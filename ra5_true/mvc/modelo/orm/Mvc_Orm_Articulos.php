<?php

// Creación del espacio de nombres
namespace mvc\modelo\orm;

use orm\modelo\ORMArticulo;

class Mvc_Orm_Articulos extends ORMArticulo{
    public function get_ofertas(): array{
        // Preparamos la sentencia sql ya que la instancia de la base de datos ORMArticulo ya la tiene heredada
        $sql = "SELECT referencia, descripcion, pvp, dto_venta";
        $sql.= " FROM articulo";
        $sql.= " WHERE dto_venta = (SELECT max(dto_venta) from articulo)";
        $stmt = $this->pdo->prepare($sql);

        // Ejecutamos la consulta
        if ($stmt->execute()){
            $articulos = $stmt->fetchAll();;
            return $articulos;
        } else {
            return [];
        }
    }
}
?>