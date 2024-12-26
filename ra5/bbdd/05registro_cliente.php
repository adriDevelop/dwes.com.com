<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/includes/funciones.php");

inicio_html("Crear nuevo usuario", ['./styles/general.css', './styles/formulario.css']);

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
?>
        <h1>Registro de nuevo usuario</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <fieldset>
            <legend>Introduce tus datos</legend>
            <label for="nif">NIF</label>
            <input type="text" name="nif" id="nif" require
             pattern="[0-9]{8}[A-Za-z]">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" require>
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" require>
            <label for="clave">Clave</label>
            <input type="password" name="clave" id="clave" require>
            <label for="iban">Iban</label>
            <input type="text" name="iban" id="iban" require
            pattern="ES[0-9]{2} [0-9]{4} [0-9]{4} [0-9]{2} [0-9]{10}" 
            value="ES00 1234 5678 90 1234567891">
            <label for="telefono">Telefono</label>
            <input type="tel" name="telefono" id="telefono">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
            <label for="acepto"></label>
            <input type="checkbox" name="acepto" id="acepto" require>Acepto la política de privacidad
            <a href="">Política de tratamiento de datos personales</a>
        </fieldset>
        <input type="submit" name="operacion" id="operacion">
    </form>

<?php
} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Saneamos los datos
    $filtros_saneamiento = ['nif' => FILTER_SANITIZE_SPECIAL_CHARS,
                            'nombre' => FILTER_SANITIZE_SPECIAL_CHARS,
                            'apellidos' => FILTER_SANITIZE_SPECIAL_CHARS,
                            'clave' => FILTER_DEFAULT,
                            'iban' => FILTER_SANITIZE_SPECIAL_CHARS,
                            'telefono' => FILTER_SANITIZE_NUMBER_INT,
                            'email' => FILTER_SANITIZE_EMAIL
                            ];
    
    $datos_saneados = filter_input_array(INPUT_POST, $filtros_saneamiento, false);

    // Validacion de datos
    $datos_saneados['nif'] = preg_match("/[0-9]{8}[A-Za-z]{1}/", $datos_saneados['nif']) ? $datos_saneados['nif'] : False; 
    $datos_saneados['iban'] = preg_match("/ES[0-9]{2} [0-9]{4} [0-9]{4} [0-9]{2} [0-9]{10}/", $datos_saneados['iban']) ? $datos_saneados['iban'] : False;
    $datos_saneados['telefono'] = preg_match("/[0-9]{9}/", $datos_saneados['telefono']) ? $datos_saneados['telefono'] : Null;
    $datos_saneados['email'] = filter_var($datos_saneados['email'], FILTER_VALIDATE_EMAIL);
    
    // Tenemos los campos y podemos insertar el cliente.
    try{
        $servidor = "mysql";
        $puerto = 3306;
        $usuario = "usuario";
        $clave = "usuario";
        $schema = "tiendaol";

        $cbd = new mysqli($servidor, $usuario, $clave, $schema, $puerto);

        $sql = "INSERT INTO cliente (nif, nombre, apellidos, clave, iban, telefono, email, ventas) ";
        $sql.= "VALUES (?, ?, ?, ?, ?, ?, ?, 0)";

        $stmt = $cbd->prepare($sql);

        $datos_saneados['clave'] = password_hash($datos_saneados['clave'], PASSWORD_DEFAULT);

        $valores = array_values($datos_saneados);

        $stmt->bind_param("sssssss", ...$valores);

        if ($stmt->execute() && $stmt->affected_rows == 1){
            echo "<h3>Bienvenido, {$datos_saneados['nombre']}</h3>";
            echo "<a href='04autenticacion.php'>Vaya a autenticarse</a>";
        } else{
            echo "<a href='{$_SERVER['PHP_SELF']}'>Error, vuelve a intentarlo.</a>";
            throw new mysqli_sql_exception("No se ha completado la ejecucion de la consulta.");
        } // Comprobar si se ha ejecutado correctamente.

    }catch(mysqli_sql_exception $mse){
        echo "<h3>Error de la aplicación</h3>";
        echo "<p>Código de error: {$mse->getCode()}</p>";
        echo "<p>Mensaje de error: {$mse->getMessage()}</p>";
    }finally{
        $cbd->close();
    }
}




fin_html();
?>