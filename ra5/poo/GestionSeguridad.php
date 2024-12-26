<?php
interface GestionSeguridad {
    // Puede tener elementos como constantes y estáticos.
    public const LONGITUD_MINIMA_CLAVE = 6;
    public const LONGITUD_PIN = 4;
    // Realizamos las cabeceras de los métodos.
    public function autenticar($token): bool;
    public function cambiarToken($token_actual, $token_nuevo): bool;
}

?>