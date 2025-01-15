<?php
namespace util;

use Exception;

class Autocarga {
    public static function registra_autocarga(){
        try{
            spl_autoload(self::class . "::autocarga");
        }catch(Exception $e){
            echo "La definición de la clase no se ha encontrado";
            exit(1);
        }
    }

    public static function autocarga($clase) :void{
        $directorios = ['/ra5', '/ra5_true'];

        $encontrado = false;

        $clase = str_replace("\\", "/", $clase);
        foreach($directorios as $directorio){
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com." . $directorio . "/{$clase}.php")){
                require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com." . $directorio . "/{$clase}.php");
                $encontrado = true;
                break;
            }
        }
        if ( !$encontrado ) throw new Exception ("La clase $clase no existe");
    }
}
?>