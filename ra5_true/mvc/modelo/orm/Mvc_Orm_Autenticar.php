<?php
    namespace mvc\controlador;

use Cliente;
use orm\Entidad\Cliente as EntidadCliente;
use orm\modelo\ORMCliente;

    class Mvc_Orm_Autenticar extends ORMCliente{
        public function busca_cliente($datos): object{
            $sql = "SELECT nif, nombre, apellidos, clave, iban, telefono, email, ventas";
            $sql.= " FROM $this->tabla";
            $sql.= " WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(':email', $datos);
            if ($stmt->execute()){
                $datos = $stmt->fetch();
                $cliente = new EntidadCliente($datos);
                if ($cliente){
                    return $cliente;
                } else {
                    return null;
                }
            }
        }
    }
?>