<?php

namespace mvc\controlador;
use Exception;
use mvc\modelo\M_Main;
use mvc\vista\V_Main;
use mvc\modelo\M_Articulos;
use mvc\vista\V_Articulos;
use mvc\modelo\M_Buscar;
use mvc\vista\V_Buscar;

require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/ra5_true/mvc/vista/V_error.php");

class Controlador {
    protected string $peticion;
    protected string $vista_error = "mvc\\vista\\V_error";

    protected array $peticiones;

    public function __construct()
    {
        $this->peticiones = [
            'Main' => ['modelo' => 'mvc\\modelo\\M_Main',
                        'vista' => 'mvc\\vista\\V_Main'
                     ],
            'articulos' => [
                        'modelo' => "mvc\modelo\\M_Articulos",
                        'vista' =>"mvc\\vista\\V_Articulos"
                     ],
            'buscar' => [
                        'modelo' => "mvc\\modelo\\M_Buscar",
                        'vista' => "mvc\\vista\\V_Buscar"
            ],
            'autenticar' => [
                        'modelo' => "mvc\\modelo\\M_Autenticar",
                        'vista' => "mvc\\vista\\V_Autenticar"
            ]

            ];
    }
    
    public function gestiona_peticion(){
        try{
        // Obtener la petición
        $peticion = $_GET['idp'] ?? $_POST['idp'] ?? "Main";
        $this->peticion = filter_var($peticion, FILTER_SANITIZE_SPECIAL_CHARS);

        // $clase_modelo = "mvc\\modelo\\M_" . ucfirst($this->peticion);
        // $clase_vista = "mvc\\vista\\V_" . ucfirst($this->peticion);

        if (array_key_exists($peticion, $this->peticiones)){
            $clase_modelo = $this->peticiones[$peticion]['modelo'];
            $clase_vista = $this->peticiones[$peticion]['vista'];
        }

        // Gestión de error si el modelo o la vista no existen
        if (!class_exists($clase_modelo)){
            throw new Exception("La clase modelo $clase_modelo no existe", 1);
        }
        if (!class_exists($clase_vista)){
            throw new Exception("La clase vista $clase_vista no existe", 2);
        }

        // Instanciar las clases modelo y vista
        $modelo = new $clase_modelo();
        $datos = $modelo->despacha();

        $vista = new $clase_vista();
        $vista->genera_salida($datos);

        }catch(Exception $e){
            $vista_error = new $this->vista_error();
            $vista_error->genera_salida($e);
        }
    }
}
?>