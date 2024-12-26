<?php
namespace orm\ob;

/*Clase Database según el patrón singleton:

    Solo se permite una instancia de esta clase
    Un constructor privado que crea un objeto PDO
    2 métodos
        getInstance()  Devuelve la instancia de la clase. Si no existe, la crea.
        getConexion()  Devuelve la conexion de la base de datos.

*/

use \PDO;
class Database{

    private static $instance = null;
    private PDO $pdo;

    private function __construct(){
        $dsn = "mysql:host=mysql;dbname=tiendaol;charset=utf8mb4";
        $usuario = 'usuario';
        $clave = 'usuario';
        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try{
            $this->pdo = new PDO($dsn, $usuario, $clave, $opciones);
        } catch(PDOException $pdoe){
            exit();
        }
    }
}

?>