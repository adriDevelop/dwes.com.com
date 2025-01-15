<?php
namespace mvc\modelo;

use Error;
use Exception;
use mvc\controlador\Mvc_Orm_Autenticar;
use orm\mvc\modelo\orm\Mvc_Orm_LEnvio;

class Autenticar implements Modelo{
    // Devuelve un array de datos
    public function despacha(): mixed
    {
        $clave_email = $this->sanear_y_validar();
        $this->autentica_cliente($clave_email);
        $orm_envios = new Mvc_Orm_LEnvio();
        $cliente = $_SESSION['cliente'];
        $envios = $orm_envios->get_envios($cliente->nif);
        return $envios;

    }

    public function sanear_y_validar(): array{
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $clave = $_POST['clave'];

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (!$email){
            throw new Exception("El email no es válido", 4001);
        } else {
            return ['email' => $email, 'clave' => $clave];

        }
    }

    public function autentica_cliente($datos): bool{
        $orm_Autenticar = new Mvc_Orm_Autenticar();
        $cliente = $orm_Autenticar->busca_cliente($datos['email']);

        if ($cliente == null){
            throw new Exception("El cliente no existe", 4002);
        }else {
            if (password_verify($datos['clave'], $cliente->clave)){
                // Crear el JWT
                $payload = [
                    'nombre' => $cliente->nombre,
                    'apellidos' => $cliente->apellidos,
                    'email' => $cliente->email
                ];

                $jwt = generar_token($payload);

                $duracion_actual = ini_get("session.gc_maxlifetime()");
                setcookie('jwt', $jwt, $duracion_actual, "/", "dwes.es", false, true);

                return true;
            }else {
                throw new Exception("La clave no es válida", 4003);
            }
        }
    }
}
?>