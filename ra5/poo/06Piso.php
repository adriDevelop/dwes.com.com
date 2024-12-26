<?php
require_once("06Vivienda.php");

class Piso extends Vivienda{
    public int $planta;
    public string $puerta;

    public function __construct(string $ref_cat, string $direc, int $sup, int $planta, string $puerta)
    {
        parent::__construct($ref_cat, $direc, $sup);
        $this->planta = $planta;
        $this->puerta = $puerta;
    }

    public function getValorEstimado(float $precio_m) : float {
        $valor_estimado = parent::getValorEstimado($precio_m);
        $valor_estimado += $this->planta * 0.1 * $valor_estimado;
        return $valor_estimado;
    }

    public function __toString(): string
    {
        return parent::__toString() . " " . "Planta: $this->planta, Puerta: $this->puerta, Dirección: $this->direccion";
    }
}

?>