<?php
namespace mvc\modelo;
use mvc\modelo\Modelo;
use mvc\modelo\orm\Mvc_Orm_Articulos;

class M_Main implements Modelo{
 public function despacha(): mixed
 {
    // Iniciamos la sesión para inicializar el carrito
    session_start();

    // Si el usuario se ha autenticado
    if ( !isset($_COOKIE['jwt'])){
        $this->sin_usuario_autenticado();
        
    } 
    // Si no se ha autenticado
    else {
        $this->con_usuario_autenticado();
    }

    // Ahora, deberemos de retornar todas las ofertas
    $orm_articulo = new Mvc_Orm_Articulos();
    $articulos_oferta = $orm_articulo->get_ofertas();
    return $articulos_oferta;
 }

 private function sin_usuario_autenticado(){
    // E inicializamos un array con los datos del carrito
    $_SESSION['carrito'] = [];
 }

 private function con_usuario_autenticado(){

 }
}
?>