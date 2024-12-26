<?php
namespace ra6\poo;
class Empleado{
    public string $nif;
    public string $nombre;

    public function __construct(string $nif, string $nombre)
    {
        $this->nif = $nif;
        $this->nombre = $nombre;
    }

    public function __toString()
    {
        return "DNI: $this->nif<br> Nombre: $this->nombre";
    }
}

?>