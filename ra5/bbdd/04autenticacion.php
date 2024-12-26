<?php

    ob_start();

    require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/includes/funciones.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/ejercicios_bbdd/conexion_bbdd.php");
    require_once("03jwt_include.php");


    inicio_html("Autenticación usuario", ['./styles/general.css', './styles/formulario.css']);
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

        $servidor = "mysql";
        $puerto = 3306;
        $usuario = "usuario";
        $clave = "usuario";
        $schema = "tiendaol";

        $sql = "SELECT nif, nombre, apellidos, email, clave FROM cliente WHERE email = ?";

        $resultado = conexion_bbdd($servidor, $usuario, $clave, $schema, $puerto,  $sql);

        if ( $resultado->num_rows == 1){
            // El usuario existe.
            // Comprueblo la clave.
            $cliente = $resultado->fetch_assoc();

            if (password_verify($clave_form, $cliente['clave'])){
                // Usuario autenticado
                
                $payload = [
                    'nif' => $cliente['nif'],
                    'nombre' => "{$cliente['nombre']} {$cliente['apellidos']}",
                    'email' => $cliente['email']
                ];

                $jwt = generar_token($payload);
                setcookie("jwt", $jwt, time() + 30 * 60);
                echo "Vaya a editar sus datos <a href='06pagina_inicio.php'>editar</a>'";
            } else {
                echo "<h3>Error en la aplicación</h3><br>";
                echo "<h3>{$clave} {$cliente['clave']}</h3>";
                echo "<h3>La clave no es correcta</h3>";
                echo "<a href='{$_SERVER['PHP_SELF']}'>Vuelve a intentarlo</a>";
            }

        }else {
            echo "<h3>Error en la aplicación</h3><br>";
            echo "<h3>El usuario ·email no existe</h3>";
            echo "<a href='{$_SERVER['PHP_SELF']}'>Vuelve a intentarlo</a>";
        }

        }catch(mysqli_sql_exception $exc){
          echo "{$exc->getMessage()}";
        }

    }

    $ob_content = ob_get_contents();
    ob_flush();

    fin_html();
?>