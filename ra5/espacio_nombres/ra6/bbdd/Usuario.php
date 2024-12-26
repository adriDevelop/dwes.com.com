<?php
namespace ra6\bbdd; // El nombre de la clase pasaría a ser ra6\bbdd\Usuario
class Usuario{
    public string $login;
    protected string $password;
    public string $perfil;

    public function __construct(string $login, string $password, string $perfil)
    {
        $this->login = $login;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->perfil = $perfil;
    }

    public function __toString()
    {
        return "Login: $this->login<br> Perfil: $this->perfil";
    }
}

?>