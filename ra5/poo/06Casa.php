<?php
/* 
    Nivel de acceso:

    Las propiedades y métodos de una clase se pueden declarar:
    - private -> Solo es accesible desde dentro de la clase.
    - protected -> Solo es accesible desde dentro de la clase y clases derivadas.
    - public -> Es accesible desde cualquier parte.
*/

class Casa extends Vivienda{
    public int $sup_patio;
    public int $sup_jardin;

    public static int $METRO_JARDIN = 30;
    public static int $METRO_PATIO = 25;

    public function __construct(string $ref_catastral, string $direccion, int $superficie, int $sup_patio, int $sup_jardin)
    {
        parent::__construct($ref_catastral, $direccion, $superficie);
        $this->sup_patio = $sup_patio;
        $this->sup_jardin = $sup_jardin;
    }

    public function getValorEstimado($precio_m): float{
        $valor_estimado = parent::getValorEstimado($precio_m);
        $valor_estimado += $this->sup_patio * self::$METRO_PATIO;
        $valor_estimado += $this->sup_jardin * self::$METRO_JARDIN;
        return $valor_estimado;
    }

    public function __toString(): string
    {
        return parent::__toString() . " " . "$this->sup_patio m<sup>2</sup> $this->sup_jardin m<sup>2</sup>";
    }

}

?>
