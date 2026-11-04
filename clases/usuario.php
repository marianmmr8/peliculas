<?php
class Usuario{
    //atributos lo que sale de los objetos(cuadrados base de datos german)
    private ?int $id;
    private string $nombre;
    private string $password;
    private string $rol;

    public function __construct(string $nombre, string $password, ? string $rol ="usuario", ?int $id = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->password = $password;
        $this->rol = $rol;
    }

    //get es pra devolver el valor d elos atributos

    public function getId():int {
        return $this->id;
    }
public function getNombre():string {
        return $this->nombre;
    }
    public function getPassword():string {
        return $this->password;
    }
public function getRol():string {
        return $this->rol;
}
    //los setters son para cambiar el valor d elos atributos

    public function setId(int $id){
        $this->id = $id;
    }
     public function setNombre(string $nombre){
        $this->nombre = $nombre;
    }
     public function setPassword(string $password){
        $this->password = $password;
    }
public function setRol(string $rol){
        $this->rol = $rol;
    }




}



?>