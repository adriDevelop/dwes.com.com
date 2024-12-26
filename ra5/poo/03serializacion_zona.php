<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/ra5/poo/includes/funciones.php");
require_once("Usuario.php");

session_start();

if (isset($_SESSION['usuario'])){
    // Deserialización.
    $objeto_usuario = $_SESSION['usuario'];

    echo "<h3>Zona de usuarios con perfil $objeto_usuario->perfil</h3>";
    echo "";


}

?>