<?php

require_once("GestionSeguridad.php");

class Cliente implements GestionSeguridad{
    private string $email;
    private string $nombre;
    private string $pin;

    public function __construct(string $email, string $nombre, string $pin)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->pin = $pin;
    }

    public function __get(string $nombre_propiedad): mixed
    {
        if (property_exists(self::class, $nombre_propiedad)){
            if ($nombre_propiedad != 'ping'){
                return $this->$nombre_propiedad;
            }
        }
        return null;
    }

    public function __set($nombre_propiedad, $valor)
    {
        if (property_exists(self::class, $nombre_propiedad)){
            if ($nombre_propiedad != 'pin'){
                $this->$nombre_propiedad = $valor;
            }
        }  
    }

    public function autenticar($token): bool
    {
        return $token == $this->pin;
    }

    public function cambiarToken($token_actual, $token_nuevo): bool
    {
        if ( $this->autenticar($token_actual)){
            if (mb_strlen($token_nuevo) == GestionSeguridad::LONGITUD_PIN){
                $this->pin = $token_nuevo;
            }else{
                return false;
            }
        } else{
            return false;
        }
        
    }
}

?>