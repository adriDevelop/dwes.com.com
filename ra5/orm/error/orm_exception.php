<?php
namespace orm\error;

use Exception;
use orm\util\Html;

class ORMException extends Exception {
    protected int $tipo;
    protected array $pr;
    protected int $cod_err;
    protected int $nivel;
    public const ERROR_FATAL = 1;
    public function __construct(Exception $e, int $tipo, array $pr = null, int $nivel, int $cod_err)
    {
        parent::__construct($e->getMessage(), $e->getCode(), $e->getPrevious());
        $this->tipo = $tipo;
        $this->pr = $pr;
        $this->nivel = $nivel;
        $this->cod_err = $cod_err;
    }

    public function gestiona_error(){
        echo "<h3>Error de la apliacacion</h3>";
        echo "<p>Mensaje: " . $this->getMessage() . "<br>";
        echo "Codigo Excepcion: " . $this->getMessage() . "<br>";
        $archivo = explode("/", $this->getFile());
        echo "Archivo: " . end($archivo) . "<br>";
        echo "Linea: " . $this->getLine(). "<br>";

        if ($this->nivel == self::ERROR_FATAL){
            Html::fin();
        }

        if ($this->pr){
            echo "<p><a href='{$this->pr}'></a></p>";
        }
    }
}
?>