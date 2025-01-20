<?php

// Autocarga
require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/ra5_true/util/Autocarga.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/ra5_true/mvc/Controlador/Controlador.php");
use util\Autocarga;
Autocarga::registra_autocarga();

use mvc\controlador\Controlador;

$controlador = new Controlador();
$controlador->gestiona_peticion();
?>