<?php
// esta funcion es para unir las bases de datos requiere, requiere_once, include_once o include , 
// sus diferencias son que requiere da error cuando no encuentra un archivo y para la ejecucion,
//  el include solo da un warning y el termino once hace que solo se importe una vez no se repita

require_once __DIR__ . "/director.php";
require_once __DIR__ . "/../datos/config.php";

// creamos una conexion con la base de datos 
class directorDao{

private PDO $conexion;

public function __construct()
{
    global $servidor, $nombreBase, $usuario, $password;

    $dsn = "mysql:host=$servidor;dbname=$nombreBase;charset=utf8mb4";
    $this->conexion = new PDO($dsn, $usuario, $password);
}
public function getAll():array{
    $sql = "SELECT * FROM director";

    $stmt = $this->conexion->query($sql);
    $directores = [];

    while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
$directores[] = new Director(
    $fila["nombre"],
    $fila["nacimiento"],
    $fila["biografia"],
    $fila["id"]

);
    }

return $directores;

}








}





?>