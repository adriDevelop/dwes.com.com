<?php

class Chalet extends Casa{
    public int $sup_piscina;
    public int $sup_jardin;

    // Si un constructor es privado, no lo puedo usar para instancias un objeto de la clase.

    // Tendría que definir un método estático que crea un objeto de la clase usando el constructor
    // privado y luego devuelve la instancia de ese objeto.
    public static function getChalet(string $ref_catastral, string $direccion, int $superficie, int $sup_patio, int $sup_jardin, int $sup_piscina): self{
        $chalet = new self($ref_catastral, $direccion, $superficie, $sup_patio, $sup_jardin, $sup_piscina);
        return $chalet;
    }
}

?>