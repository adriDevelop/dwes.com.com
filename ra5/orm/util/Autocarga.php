<?php
namespace orm\util;

use Exception;

class Autocarga{
    private const string DIRECTORIO_BASE = "/ra5";
    public static function registro_autocarga():void {
        try{
            spl_autoload_register(self::class . "::autocarga");
        }catch( Exception $e ){
            echo $e->getMessage();
        }
        
    }

    public static function autocarga(string $clase):void {
        $clase = str_replace('\\', "/", $clase);
        error_log("Clase procesada: $clase"); 
        $directorio = $_SERVER['DOCUMENT_ROOT'] . self::DIRECTORIO_BASE;
        if (file_exists( $directorio . "/$clase.php")){
            require_once($directorio . "/$clase.php");
        } else {
            throw new Exception("El archivo con la definición de $clase no exite", 1);
        }
    }
}

?>