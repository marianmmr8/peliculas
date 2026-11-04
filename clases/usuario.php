<?php
class Usuario{
    //atributos lo que sale de los objetos(cuadrados base de datos german)
    private ?int $id;
    private string $nombre;
    private string $password;

    public function __construct(string $nombre, string $password, ?int $id = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->password = $password;
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




}



?>