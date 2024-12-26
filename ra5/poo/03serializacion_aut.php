<?php
ob_start();

/*
    Serializacion.

    Proceso de convertir un objeto en una cadena de caracteres.
    Útil para almacenar objetos en BBDD o archivos.
    La función integrada serialize() realiza esta conversión objeto->cadena.
    La función integrada unserialize() realiza el proceso contrario.
    convirtiendo la cadena en el objeto.

    La serializacion se emplea en las sesiones PHP, al guardar objetos
    como variables de sesión.
    PHP serializa, al añadir un objeto como variable de sesión ( en $_SESSION )
    y deserializa vuando se cargan las variables de sesión (al invocar session_start() )

    IMPORTANTE: La definición de la clase de objeto tiene que estar disponible antes de que se realice la deseatilzación.
    De lo contrario crea un objeto de la clase StdClass que es totalmente inútil.

    Método mágico __sleep()
        Se invoca por serialize() justo antes de la serialización para preservar el estado del objeto, es decir, las propiedades
        del objeto.
        El método mágico __serialize() se invoca también por serialize() y tiene precencia sobre sleep(). Si existe __serialize() no se invoca
        __sleep().
        Este método obligatoriamente devuelve un array con las propiedades públicas, ya que serialize no tiene acceso a propiedades
        públicas o privadas.
        El método debe hacer tareas de limpieza antes de la serialización, como confirmar cambios en la BBDD o cerrar archivos.

    Método mágico __wakeup()
        Al invocar la función unserialize() sobre un objeto serializado, se invoca 
        _wakeup() para restaurar el objeto.
        El método mágico __unserialize() se invoca automáticamente por unserialize() y tiene precedencia sobre __wakeup().
        No tienen argumentos ni devuelve valor.
        Se emplea para restaurar objetos en variables de sesión, y además, restaura en el objeto recursos (conexiones de BBDD o punteros
        a archivo) que se puedan necesitar al deserializar el objeto.

    Ejemplo:

        Clase usuario:
            Login.
            Nombre.
            Perfil.
            Archivo logs donde se registra su actividad.
        
        Script para autenticar un usuario:
            Si tiene exito crea un objeto de la clase usuario y o almaceno como variable de sesión.
        
        Script para que el usuario acceda a su zona restringida donde:
            Recuperamos la variable de sesión (El objeto usuario).
            Mostramos sus propiedades.

*/
require_once("Usuario.php");

session_start();

date_default_timezone_set('Europe/Madrid');

require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/ra5/poo/includes/funciones.php");


function autentica_usuario(string $login, string $password): mixed{
    $usuarios = ['manuel@gmail.com' => ['nombre' => 'Manuel Garcia Lopez', 'password' => password_hash("manuel", PASSWORD_DEFAULT), 'perfil' => USUARIO::PERFIL_ADMIN],
                 'maria@gmail.com' => ['nombre' => 'Manuel Garcia Lopez', 'password' => password_hash("manuel", PASSWORD_DEFAULT), 'perfil' => USUARIO::STANDARD],
                 'javier@gmail.com' => ['nombre' => 'Manuel Garcia Lopez', 'password' => password_hash("manuel", PASSWORD_DEFAULT), 'perfil' => USUARIO::INVITADO]];

    if ( array_key_exists($login, $usuarios)){
        if ( password_verify($password, $usuarios[$login]['password'])){
            return $usuarios[$login];
        } else {
            Error("La clave introducida no es válida", $_SERVER['PHP_SELF'], 'Intentalo de nuevo');
        }
    } else {
        return false;
    }
}

function Error(string $mensaje, string $url, string $enlace){
    inicio_html("Error de autenticación", []);
        echo "<h3>Error de la aplicación</h3>";
        echo "<p>$mensaje</p>";
        echo "<a href='$url'>$enlace</a>";
    fin_html();
    exit(1);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if ($login){
        Error("El login de usuario no tiene el formato adecuado", $_SERVER['PHP_SELF'], 'Volver a intentarlo');
    }

    $password = $_POST['password'];

    $datos_usuario = autenticacion_usuario($login, $password);
    if ( $datos_usuario ){
        // Autenticación con exito.
        $objeto_usuario = new Usuario($login, $datos_usuario['nombre'], $datos_usuario['perfil'], "$login.log");
        $objeto_usuario->registraActividad("Usuario autenticado con éxito");

        $_SESSION['usuario'] = $objeto_usuario;
        inicio_html("Serializacion de objetos en PHP", ['/estilos/general.css', '/estilos/formulario.css']);
        echo "<header>Serialización de objetos en PHP</header>";
        echo "<h3>Zona de usuarios autenticados</h3>";
        echo "<p>Bienvenido, {$objeto_usuario->nombre}. Se autenticado con éxito y puede ir a su zona</p>";
        echo "<p></p>";

    } else {
        Error("Autenticación fallida", $_SERVER['PHP_SELF'], 'Volver a intentarlo');
    }

}
elseif($_SERVER['REQUEST_METHOD'] == 'GET'){
    ?>
    <form action="<?=$_SERVER['PHP_SELF']?>">
        <fieldset>
            <legend>Autenticación de usuario</legend>
            <label for="login">Login</label>
            <input type="email" name="email" id="email" size="20" required>
            <label for="password">Clave</label>
            <input type="password" name="password" id="password" size="10" required>
        </fieldset>
        <input type="submit" name="operacion" id="operacion" value="Abrir sesión">
    </form>
    <?php
}

$headers_recogidos = ob_get_contents();
ob_clean();
echo "$headers_recogidos";
fin_html();
?>