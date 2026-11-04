<?php
// aqui estan los datos que queremos que se vean id, nombre, año de nacimiento y biorafia
class Director{
    //propiedades o atributos
    private ?int $id;
private string $nombre;
private int $anioNacimiento;
private string $biografia;


/**
 * Crea un director con sus datos personales y, opcionalmente, su identificador.
 *
 * @param string $nombre Nombre del director.
 * @param int $nacimiento Año de nacimiento.
 * @param string $biografia Biografía del director.
 * @param int|null $id Identificador del director, o null si aún no está guardado.
 */
public function __construct(string $nombre, int $nacimiento, string $biografia = " " , ?int $id = null)
{
$this->id = $id;
$this-> nombre = $nombre;
$this-> anioNacimiento = $nacimiento;
$this->biografia = $biografia;

}
// getter funciones que se usan para coger los valores 
/** Devuelve el identificador del director. */
public function getId(): int{
    return $this->id;
}
/** Devuelve el nombre del director. */
public function getNombre(): string{
    return $this->nombre;
}

/** Devuelve el año de nacimiento del director. */
public function getAnioNacimiento() : int{
    return $this-> anioNacimiento;
}
/** Devuelve la biografía del director. */
public function getBiografia(): string{
    return $this->biografia;
}
// setters son la funcion que cambian los valores privados
/** Asigna el identificador del director. */
public function setId(int $id){
    $this->id = $id;
}
/** Cambia el nombre del director. */
public function setNombre( string $nombre){
    $this->nombre = $nombre;

}

/** Cambia el año de nacimiento del director. */
public function setAnionacimiento( int $anioNacimiento){
    $this->anioNacimiento = $anioNacimiento;
$director1 = new Director("Alejandro Almenabar", 2000);

}
/** Cambia la biografía del director. */
public function setBiografia( string $biografia){
    $this->biografia = $biografia;

}

/** Devuelve una frase con el nombre y el año de nacimiento del director. */
public function __toString(): string
{
    return "El director $this->nombre nació en $this->anioNacimiento";
}

}
?>