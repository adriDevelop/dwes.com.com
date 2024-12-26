<?php

    ob_start();

    require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/includes/funciones.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/ejercicios_bbdd/conexion_bbdd.php");
    require_once("03jwt_include.php");


    inicio_html("Autenticación usuario", ['../../styles/general.css', '../../styles/formulario.css']);
    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        // Formulario de autenticación.
        ?>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                <fieldset>
                    <legend>Introduzca sus credenciales</legend>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                    <label for="clave">Clave</label>
                    <input type="password" name="clave" id="clave" require>
                </fieldset>
                <input type="submit" name="operacion" id="operacion">
            </form>
            <a href='05registro_cliente.php'>No soy cliente y quiero registrarme</a>
        <?php
        
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        $clave_form = $_POST['clave'];

        if (!$email){
            echo "<h3>Error. Email no tiene formato correcto.</h3>";
            echo "<a href='{$_SERVER['PHP_SELF']}'>Volver a intentarlo</a>";
        }

        try{
            $dsn = "mysql:host=mysql;port=3306;dbname=tiendaol;charset=utf8mb4";
            $usuario = "usuario";
            $clave = "usuario";
            $opciones = [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::ATTR_EMULATE_PREPARES => false
            ];

            $pdo = new PDO($dsn, $usuario, $clave, $opciones);

            $sql = "SELECT nif, nombre, apellidos, email, clave FROM cliente WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $email);

            if($stmt->execute()){
                if ($stmt->rowCount() == 1){
                    $usuario = $stmt->fetch();
                    if (password_verify($clave, $usuario['clave'])){

                        $payload = [
                            'nif' => $usuario['nif'],
                            'nombre' => $usuario['nombre'] . " " . $usuario['apellidos'],
                            'email' => $usuario['email'],
                        ];

                        $jwt = generar_token($payload);

                        setcookie("jwt", $jwt, time() + 24 * 60);

                        echo "<h3>Autenticación correcta.</h3>";
                        echo "<h3><a href='../bbdd/06pagina_inicio.php'>Acceder a la zona de autenticación</a></h3>";
                    } else {

                    }
                } else {
                    $e = new Exception("<h3>No existe el valor</h3>", 9000);
                    mostrar_error($e);
                }
            }else {
                $e = new Exception("<h3>Error al ejecutar la consulta</h3>", 9000);
                    mostrar_error($e);
            }
        }catch(PDOException $e){
            mostrar_error($e);
        }

    }

    $ob_content = ob_get_contents();
    ob_flush();

    fin_html();
?>