<?php

class Direccion {
    private string $tipo_via;
    private string $nombre_via;
    private int $numero;
    private int $portal;
    private string $escalera;
    private int $planta;
    private string $puerta;
    private string $localidad;
    private int $postal;

    private const array TIPOS_VIAS = ["C/", "Av", "Pz", "Ps", "Crta"];

    private const array MAPEO_METODOS = ['cambiarVia' => 'setTipoVia',
                                         'cambiarCalle' => 'setNombreVia'];

    public function __construct(string $tv, string $nv, int $nm, int $portal, string $escalera, int $planta, string $puerta, int $codigo_postal, string $lc)
    {
        $this->setTipoVia($tv);
        $this->nombre_via = $nv;
        $this->numero = $nm;
        $this->portal = $portal;
        $this->escalera = $escalera;
        $this->planta = $planta;
        $this->puerta = $puerta;
        $this->localidad = $lc;
        $this->postal = $codigo_postal;
        
    }

    // Sobrecarga de propiedades.
    public function getTipoVia(): string{
        return $this->tipo_via;
    }

    private function setTipoVia(string $tipo_via){
        if (in_array($tipo_via, self::TIPOS_VIAS)){
            $this->tipo_via = $tipo_via;
        } else { 
            $this->tipo_via = null;
        }
    }

    private function setNombreVia(string $nombre_via): void{
        $this->nombre_via = $nombre_via;
    }

    // Metodo que recibe el nombre de la propiedad que se quiere devolver.
    public function __get(string $propiedad): mixed{
        if(property_exists(self::class, $propiedad)){
            return  $this->$propiedad;
        }else{
          return "<p>Propiedad $propiedad sin definir en " . __CLASS__ . "</p>";
        }
    }

    // Metodo que recibe el nombre de la propiedad y el valor de esta.
    public function __set(string $propiedad, mixed $valor): void{
        if(property_exists(__CLASS__, $propiedad)){
            $this->$propiedad = $valor;
        }else {
            echo "<p>Warning: La propiedad $propiedad no se encuentra definida en " . __CLASS__ . "</p>";
        }
    }

    // Metodo que devuelve true si la propiedad esta establecida, false si no esta establecia.
    public function __isset(string $propiedad): bool{
        if (property_exists(__CLASS__, $propiedad)){
            return isset($this->$propiedad) ? true : false;
        }
        else {
            return false;
        }
    }

    // Metodo que quita el valor que tenga la propiedad.
    public function __unset(string $propiedad){
        if (property_exists(__CLASS__, $propiedad)){
            unset($this->$propiedad);
        }
        else{
            echo "<p>Warning: Esta propiedad no existe</p>";
        }
    }

    // Metodo toString().
    public function __toString(): string{
        $cadena = self::class;
        $cadena.= ":Tipo via:{$this->tipo_via}<br> - Nombre via: {$this->nombre_via}<br> - Numero via: {$this->numero}<br> - Portal: {$this->portal}<br> - Escalera: {$this->escalera}<br> - Planta: {$this->planta}<br> - Puerta: {$this->puerta}<br> - Codigo Postal: {$this->codigo_postal}<br> - Localidad: {$this->localidad}<br>";
        return $cadena;
    }

    // Sobrecarga de métodos.
    // Recibe el nombre del método y un array con los argumentos que se le han pasado.
    public function __call(string $metodo, array $argumentos): mixed{
        if ( method_exists(__CLASS__, $metodo)){
            // Método existe.
            // Significa que el método no es accesible.
                // Invocamos el método que está almacenado en la variable método.
                // Con los ...decomponemos el array cada uno con sus argumentos.
            return $this->$metodo(...$argumentos); 
        } else {
            // Método no existe.
            // A veces esto se usa para hacer un wrapper que es lo que vamos a hacer a continuación.
            // Se trata de un envoltorio o alias que 
            if ( array_key_exists($metodo, self::MAPEO_METODOS)){
                $metodo_real = self::MAPEO_METODOS[$metodo];
                return $this->$metodo_real(...$argumentos);
            }else{
                echo "<p>No existe el método $metodo</p>";
                return null;
            }
        }

        return null;
    }

    // Método mágico debug.
    public function __debugInfo(): array{
        $salida = [];
        foreach($this as $nombrePropiedad => $valor){
            $salida[$nombrePropiedad] = $valor;
        }
        return $salida;
    }
}

?>