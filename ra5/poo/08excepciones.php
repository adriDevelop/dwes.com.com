<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/includes/funciones.php");

/*



*/

inicio_html("Excepciones en PHP", ['../styles/styles.css']);

$numero = "a";
echo "<p>Vamos a calcular el cuadro de número</p>";
try{
    $cuadrado = $numero ** 2;
} catch(TypeError $te){
    if(gettype($numero) != "int"){
        $numero = 4;
    }
    $cuadrado = $numero ** 4;
    echo "<p>El cuadrado de número es $cuadrado</p>";
    
}
echo "<p></p>";

// Ejemplo 3: Se contemplan 2 excepciones.
try{
    $x = strpos("h", "hola", 16);

    $numero = "a";
    $cuadrado = $numero ** 4;
    echo "<p>El cuadrado de número es $cuadrado</p>";
} catch (ValueError $e) {
    echo "1 Excepción: $e<br>";
} catch(TypeError $e){
    echo "2 Excepción: $e";
}

try{
    $x = strpos("h", "hola", 16);

    $numero = "a";
    $cuadrado = $numero ** 4;
    echo "<p>El cuadrado de número es $cuadrado</p>";
} catch (TypeError | ValueError $e){
    echo "Excepciones 3: $e";
}

// Ejemplo clausula finally. Se ejecuta el dódigo dentro de
// finally o no, la excepción.
echo "<h3>Cláusula finally</h3>";

try{
    $puntero = @fopen("/dwes.com.com/Subida_de_archivos/archivo_copia.php", "r");
    $número_lineas = "$";
    // Si cierro aqui el archivo y se dispara una,
    // excepción, el archivo se queda abierto.
}catch(TypeError $te){
    echo "$te";
}finally{
    // Operaciones de limpieza.
    echo "<p>Cerramos el archivo</p>";
    // fclose($puntero);
}

// Ejemplo 6: El desarrollador lanza excepciones.
echo "<h3>Lanzamiento de excepciones</h3>";
try{
    if (!file_exists("/dwes.com.com/Subida_de_archivos/archivo_copia.php")){
        throw new Exception("El archivo no existe", 1000);
    } else {
        $puntero = @fopen("/dwes.com.com/Subida_de_archivos/archivo_copia.php", "r");
        $número_lineas = "$";
        while($fila = fgets($puntero)){
            echo $fila;
        }
    }
}catch(Exception $e){
    echo "$e<br>";
}

// Ejemplo 7: Excepciones Personalizadas.
class AperturaficherExcepcion extends Exception{
    protected array $punto_recuperacion;

    public function __construct(string $message, int $codigo, string $url_punto, string $enlace, Exception $previous = null)
    {
        parent::__construct($message, $codigo, $previous);
        $this->punto_recuperacion['url'] = $url_punto;
        $this->punto_recuperacion['enlace'] = $enlace;
    }

    public function __toString(): string
    {
        return __CLASS__ . "[{$this->code}, {$this->message}]";
    }

    public function getPuntoRecuperacion():array{
        return $this->punto_recuperacion;
    }
}

try{
    if (!file_exists("01clases.pp")){
        throw new AperturaficherExcepcion("El fichero no existe", 1000, "http://dwes.es/dwes.com.com/ra5/poo/08excepciones.php", "Ir al principio de la aplicación");
    }
    $puntero = fopen("01clases.php", "r");
}catch(AperturaficherExcepcion $e){
    echo "$e";
    $e->getPuntoRecuperacion();
    echo "Punto de recuperación : <a href='{$e['url']}'>{$e['enlace']}</a>";
}

fin_html();

?>