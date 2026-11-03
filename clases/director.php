<?php
// aqui estan los datos que queremos que se vean id, nombre, año de nacimiento y biorafia
class Director{
    //propiedades o atributos
    private ?int $id;
private string $nombre;
private int $anioNacimiento;
private string $biografia;



public function __construct(string $nombre, int $nacimiento, string $biografia = " " , ?int $id = null)
{
$this->id = $id;
$this-> nombre = $nombre;
$this-> anioNacimiento = $nacimiento;
$this->biografia = $biografia;

}
// getter funciones que se usan para coger los valores 
public function getId(): int{
    return $this->id;
}
public function getNombre(): string{
    return $this->nombre;
}

public function getAnioNacimiento() : int{
    return $this-> anioNacimiento;
}
public function getBiografia(): string{
    return $this->biografia;
}
// setters son la funcion que cambian los valores privados
public function setId(int $id){
    $this->id = $id;
}
public function setNombre( string $nombre){
    $this->nombre = $nombre;

}
public function setAnionacimiento( int $anioNacimiento){
    $this->anioNacimiento = $anioNacimiento;
$director1 = new Director("Alejandro Almenabar", 2000);

}
public function setBiografia( string $biografia){
    $this->biografia = $biografia;

}

public function __toString(): string
{
    return "El director $this->nombre nació en $this->anioNacimiento";
}

}
?>