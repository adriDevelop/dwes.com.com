<?php

namespace mvc\modelo;

use mvc\modelo\orm\Mvc_Orm_Articulos;

class M_Buscar implements Modelo{
    public function despacha(): mixed
    {
        $descripcion = $this->sanear_y_validar();
        $orm_articulos = new Mvc_Orm_Articulos();
        $articulos_encontrados = $orm_articulos->get_por_descripcion($descripcion);

        return $articulos_encontrados;
    }

    public function sanear_y_validar(): string{
        // Tenemos que sanear los datos que nos envia en el formulario
        $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS);
        return $descripcion;
    }
}

?>