<?php
// Generamos la clase empleado.
class Empleado {
    // Propiedades de la clase.
    public string $nif;
    public string $nombre;
    public string $apellidos;
    public ?float $salario;

    // Se pueden definir constantes. Como? con la palabra reservada const.
    public const float IRPF = 0.2;
    public const float SS = 0.05;
    public const float SALARIO_BASE = 2000;

    // Propiedades estáticas. Se puede acceder con la clase sin necesidad de acceder o declarar al objeto.
    public static float $IRPF = 0.2;
    public static float $SS = 0.5;
    public static array $SALARIO_BASE = ['Adm' => 2000, 'Dir' => 3500];

    // Métodos estáticos.
    // No pueden acceder a las propiedades de la clase, a no ser, que sean estáticas.
    public static function getPorcentajes(): string {
        return "IRPF: ". (self::$IRPF * 100) . "%. SS: " . (self::SS * 100) .".";
    }

    public static function getFechaFormato($fecha = null): string{
        $formato_fecha = "d/M/Y G:i:s";
        if (!$fecha){
            $fecha = time();
        }
        return date($formato_fecha, $fecha);
    }

    // Generamos el constructor.
    public function __construct(string $nif, string $nombre, string $apellido, ?float $salario = null)
    {
        $this->nif = $nif;
        $this->nombre = $nombre;
        $this->apellidos = $apellido;
        $this->salario = $salario ? $salario : 2000;
    }

    // public function __construct(public string $nif, public string $nombre, public string $apellidos, public string $salario){}

    // Destructor.
    public function __destruct() {
        echo "<p>Se esta destruyendo el objeto {$this->nif}</p>";
    }

    // Metodos de la clase.
    public function getSalarioNeto(): float{
        $salario_neto = $this->salario - ($this->salario * Empleado::IRPF +
                                          $this->salario * Empleado::SS);
        return $salario_neto;
    }

    // Objetos como argumentos.
    public function esIgual(Empleado $empleado):bool{
        return $this == $empleado;
    }

    // Devolucion de objetos.
    public function salarioDuplicado() : Empleado {
        $emp = new Empleado($this->nif, $this->nombre, $this->apellidos, $this->salario*2);
        return $emp;
    }
}

?>