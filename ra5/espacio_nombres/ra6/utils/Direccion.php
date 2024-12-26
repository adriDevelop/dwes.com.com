<?php
namespace ra6\utils;
class Direccion{
    public string $tipo_via;
    public string $nombre_via;
    public int $numero;

    public function __construct(string $tipo_via, string $nombre_via, int $numero)
    {
        $this->tipo_via = $tipo_via;
        $this->nombre_via = $nombre_via;
        $this->numero = $numero;
    }

    public function __toString()
    {
        return "Tipo de vía: $this->tipo_via<br> Nombre de vía: $this->nombre_via<br> Número: $this->numero";
    }

}

?>