<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/includes/funciones.php");

inicio_html("Crear nuevo usuario", ['../../styles/general.css', '../../styles/formulario.css']);

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
        <a href="04autenticacion.php">Ir a loguearse</a>
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
    $datos_saneados['clave'] = password_hash($datos_saneados['clave'], PASSWORD_DEFAULT);
    
    // Tenemos los campos y podemos insertar el cliente.
    try{

        $dsn = "mysql:host=mysql;dbname=tiendaol;charset=utf8mb4";
        $usuario = "usuario";
        $clave = "usuario";
        $opciones = [
                     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                     PDO::ATTR_EMULATE_PREPARES => false
        ];

        $pdo = new PDO($dsn, $usuario, $clave, $opciones);
        $sql = "INSERT INTO cliente (nif, nombre, apellidos, clave, iban, telefono, email, ventas) ";
        $sql.= "VALUES(:nif, :nombre, :apellidos, :clave, :iban, :telefono, :email, 0)";

        $stmt = $pdo->prepare($sql);
        foreach($datos_saneados as $campo => $valor){
            $stmt->bindValue(":$campo", $valor);
        }

        if($stmt->execute()){
            if ($stmt->rowCount() == 1){
                echo "<h3>Registrado correctamente.</h3>";
                echo "<h3><a href='05registro_cliente.php'>Vaya a loguearse</a></h3>";
            }else {

            }
        }else{

        }

        $datos_saneados['clave'] = password_hash($datos_saneados['clave'], PASSWORD_DEFAULT);

        $valores = array_values($datos_saneados);



    }catch(PDOException $e){
        mostrar_error($e);
    }finally{
       
    }
}




fin_html();
?>