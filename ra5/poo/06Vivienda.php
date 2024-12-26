<?php

class Vivienda{
    public string $ref_catastral;
    public string $direccion;
    public int $superficie;

    public function __construct(string $ref_catastral, string $direccion, int $superficie)
    {
        $this->ref_catastral = $ref_catastral;
        $this->direccion = $direccion;
        $this->superficie = $superficie;
    }

    public function getValorEstimado(float $precio_m): float{
        return $this->superficie * $precio_m;
    }

    public function __toString(): string
    {
        return "Dirección: $this->direccion, Ref_Catastral: $this->ref_catastral";
    }
}



?>