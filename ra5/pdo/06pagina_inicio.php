<?php

session_start();

ob_start();

require_once("03jwt_include.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/includes/funciones.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/ra5/bbdd/datos_conexion.php");


if (isset($_COOKIE['jwt'])){
    $jwt = $_COOKIE['jwt'];
    $payload = verificar_token($jwt);
}

inicio_html("base de datos - msqli", ['./styles/general.css', './styles/formulario.css']);
echo "<header>Actualizacion de los datos</header>";
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    // Leer de la BD los datos actuales
    try{
        $cbd = new mysqli($servidor, $usuario, $clave, $schema, $puerto);

        $sql = "SELECT nif, nombre, apellidos, email, iban, telefono ";
        $sql.= "FROM cliente ";
        $sql.= "WHERE nif = ?";

        $stmt = $cbd->prepare($sql);
        $stmt->bind_param("s", $payload['nif']);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 0){
            throw new mysqli_sql_exception("El cliente solicitado no existe en la BD", 9000);
        }

        $cliente = $resultado->fetch_assoc();


    }catch( mysqli_sql_exception $mse){
        mostrar_error($mse);
    }
    ?>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <fieldset>
            <legend>Datos personales del cliente</legend>
            <label for="nif">nif</label>
            <input type="text" name="nif" id="nif" value="<?=$cliente['nif']?>">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?=$cliente['nombre']?>">
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" value="<?=$cliente['apellidos']?>">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?=$cliente['email']?>">
            <label for="iban">Iban</label>
            <input type="text" name="iban" id="iban" value="<?=$cliente['iban']?>">
            <label for="telefono">telefono</label>
            <input type="tel" name="telefono" id="telefono" value="<?=$cliente['telefono']?>">
        </fieldset>
        <input type="submit" name="operacion" id="operacion" value="Actualizar mis datos">
    </form>
    <?php
} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $operacion = filter_input(INPUT_POST, 'operacion', FILTER_SANITIZE_SPECIAL_CHARS);
    if( $operacion == "Actualizar mis datos"){


        $filtro_saneamiento = [
                                'nif' => FILTER_SANITIZE_SPECIAL_CHARS,
                                'nombre' => FILTER_SANITIZE_SPECIAL_CHARS,
                                'apellidos' => FILTER_SANITIZE_SPECIAL_CHARS,
                                'email' => FILTER_SANITIZE_EMAIL,
                                'iban' => FILTER_SANITIZE_SPECIAL_CHARS,
                                'telefono' => FILTER_SANITIZE_NUMBER_INT
        ];


        $datos_saneados = filter_input_array(INPUT_POST, $filtro_saneamiento);

        $filtros_validacion = [
                                'nif' => FILTER_DEFAULT,
                                'nombre' => FILTER_DEFAULT,
                                'apellidos' => FILTER_DEFAULT,
                                'email' => FILTER_VALIDATE_EMAIL,
                                'iban' => FILTER_DEFAULT,
                                'telefono' => ['filter' => FILTER_VALIDATE_INT,
                                               'options' => FILTER_NULL_ON_FAILURE,
                                              ]
        ];

        $datos_validados = filter_var_array($datos_saneados, $filtros_validacion); 

        if($datos_validados['nif']){
            $datos_validados['nif'] = preg_match("/[0-9]{8}[A-Za-z]{1}/", $datos_validados['nif']) ? $datos_validados['nif'] : False;
        }
        if ($datos_validados['iban']){
            $datos_validados['iban'] = preg_match("/ES[0-9]{2} [0-9]{4} [0-9]{4} [0-9]{2} [0-9]{10}/", $datos_validados['iban']) ? $datos_validados['iban'] : False;
        }

        try{

            $cbd = new mysqli($servidor, $usuario, $clave, $schema, $puerto);

            

        }catch(mysqli_sql_exception $mse){
            mostrar_error($mse);
        }
    }
}


$ob_get_contents = ob_get_contents();
ob_flush();
?>