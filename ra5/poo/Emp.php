<?php
require_once("GestionSeguridad.php");
class Emp implements GestionSeguridad{
    private string $nif;
    private string $nombre;
    private string $clave;

    public function __construct(string $nif, string $nombre, string $clave)
    {
        $this->nif = $nif;
        $this->nombre = $nombre;
        $this->clave = password_hash($clave, PASSWORD_DEFAULT);
    }

    public function __get(string $nombre_propiedad): mixed{
        if (property_exists(self::class, $nombre_propiedad)){
            if ($nombre_propiedad == 'clave'){
                return null;
            }
            return $this->$nombre_propiedad;
        }
        return null;
    }

    public function __set(string $nombre_propiedad, mixed $valor): void{
        if (property_exists(self::class, $nombre_propiedad)){
            if ($nombre_propiedad != 'clave'){
                $this->$nombre_propiedad = $valor;
            }
        }  
    }

    public function __toString()
    {
        return "Emp: $this->nif - $this->nombre";
    }

    public function autenticar($token): bool
    {
        return password_verify($token, $this->clave);
    }

    public function cambiarToken($token_actual, $token_nuevo): bool
    {
        if ($this->autenticar($token_actual)){
            // 1º La nueva clave tiene 4 tipos de caracteres.
            $letra_min = preg_match("/[a-z]/", $token_nuevo);
            $letra_may = preg_match("/[A-Z]/", $token_nuevo);
            $letra_num = preg_match("/[0-9]/", $token_nuevo);
            $letra_car = preg_match("/[#@$%&]/", $token_nuevo);

            if (!$letra_min && !$letra_may && !$letra_num && !$letra_car){
                return false;
            }

            if (strlen($token_nuevo >= GestionSeguridad::LONGITUD_MINIMA_CLAVE)){
                $this->clave = password_hash($token_nuevo, PASSWORD_DEFAULT);
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }

    }

?>