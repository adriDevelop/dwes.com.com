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

    public function get_por_descripcion(string $descripcion): array{
        // Preparamos la sentencia sql
        $sql = "SELECT referencia, descripcion, pvp, dto_venta, und_vendidas, und_disponibles, fecha_disponible, categoria, tipo_iva";
        $sql.= " FROM articulo";
        $sql.= " WHERE descripcion LIKE :descripcion";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(":descripcion", '%' . $descripcion . '%');

        // Ejecutamos la consulta y devolvemos los valores
        if ($stmt->execute()){
            $articulos = $stmt->fetchAll();
            return $articulos;
        }else {
            return [];
        }
    }
}
?>