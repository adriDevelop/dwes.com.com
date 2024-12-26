<?php

class Usuario {
    public string $login;
    public string $nombre;
    public string $perfil;

    private string $archivo_logs;

    // Esto es un recurso y no se usa tipo.
    private $arc_log;

    public const string PERFIL_ADMIN = 'admin';
    public const string STANDARD = 'stand';
    public const string INVITADO = 'inv';

    public function __construct(string $login, string $nombre, string $perfil, string $archivo_log){
        $this->login = $login;
        $this->nombre = $nombre;
        $this->perfil = $perfil;
        $this->archivo_logs = $archivo_log;

        $this->arc_log = fopen($this->archivo_logs, 'a'); // Si no está definido es falso.
    }

    public function __toString():string{
        return "{$this->login} - {$this->nombre} - {$this->perfil}<br>";
    }

    public function registraActividad(string $descripcion){
        if ($this->arc_log){
            $formato_fecha = "d/m/Y G:i:s"; // Formato de fecha y hora. Se encuentra en la documentación de PHP.
            $actividad = date($formato_fecha) . "->" . "$descripcion";
            fwrite($this->arc_log, $actividad);
        }
    }

    // Método mágico __sleep().
    public function __sleep():array{
        // Hacer las tareas de limpieza. (Tenemos el archivo abierto.);
        if ($this->archivo_logs){
            fclose($this->archivo_logs);
        }
        // Devuelve un array con el nombre de las propiedades que yo quiero serializar
        return Array('login', ' nombre', 'perfil', 'archivo_log');
    }

    // Método mágico __wakeUp().
    public function __wakeup():void {
        if( !$this->archivo_logs){
            fopen($this->archivo_logs, 'a');
        }
    }
}

?>