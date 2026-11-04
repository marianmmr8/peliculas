<?php
// esta funcion es para unir las bases de datos requiere, requiere_once, include_once o include , 
// sus diferencias son que requiere da error cuando no encuentra un archivo y para la ejecucion,
//  el include solo da un warning y el termino once hace que solo se importe una vez no se repita

require_once __DIR__ . "/director.php";
require_once __DIR__ . "/../datos/config.php";

// creamos una conexion con la base de datos 
class directorDao{

private PDO $conexion;

/**
 * Abre la conexión PDO con la base de datos configurada en datos/config.php.
 */
public function __construct()
{
    //aqui se realiza la conexion
    global $servidor, $nombreBase, $usuario, $password;

    $dsn = "mysql:host=$servidor;dbname=$nombreBase;charset=utf8mb4";
    $this->conexion = new PDO($dsn, $usuario, $password);
}
// esta funcion devuelve un array con todos los registros de l atabla director
/**
 * Recupera todos los directores y los convierte en objetos Director.
 *
 * @return Director[] Lista de directores; queda vacía si no hay registros.
 */
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
// esta funcion busca un director por su id
/**
 * Busca un director por su identificador.
 *
 * @param int $id Identificador del director.
 * @return Director|null El director encontrado o null si no existe.
 */
public function getById(int $id): ?Director{
    $sql = "SELECT * FROM director WHERE id = :id";

    $stmt = $this ->conexion->prepare($sql);
    $stmt->execute(["id"=> $id]);

    $fila = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$fila){
        return null;
    }
    return new Director (
        $fila["nombre"],
    $fila["nacimiento"],
    $fila["biografia"],
    $fila["id"]
    );

}
//crea un nuevo director
/**
 * Inserta un nuevo director en la base de datos.
 *
 * @param Director $director Objeto con los datos del director.
 * @return bool Indica si la consulta de inserción se ejecutó correctamente.
 */
public function setDirector(Director $director): bool{
    $sql = "INSERT INTO director (nombre,nacimiento,biografia) VALUES(:nombre,:nacimiento,:biografia)";

    $stmt = $this->conexion->prepare($sql);
    return $stmt->execute([
        "nombre" => $director->getNombre(),
        "nacimiento" => $director->getAnioNacimiento(),
        "biografia" =>$director->getBiografia()
    ]);
}
//modificar un director

/**
 * Actualiza los datos de un director existente.
 *
 * @param Director $director Objeto con los datos nuevos y el ID existente.
 * @return bool Indica si la consulta de actualización se ejecutó correctamente.
 */
public function actualizar(Director $director):bool{
    $sql = "UPDATE director
    SET nombre =:nombre,
    nacimiento =:nacimiento,
    biografia =:biografia
    WHERE id= :id";

      $stmt = $this->conexion->prepare($sql);
    return $stmt->execute([
        "nombre" => $director->getNombre(),
        "nacimiento" => $director->getAnioNacimiento(),
        "biografia" =>$director->getBiografia(),
        "id" => $director->getId()
    ]);
}

//eliminar
/**
 * Elimina de la base de datos el director indicado.
 *
 * @param int $id Identificador del director que se eliminará.
 * @return bool Indica si la consulta de eliminación se ejecutó correctamente.
 */
public function eliminar(int $id):bool{
    $sql = "DELETE FROM director WHERE id = :id";
    $stmt = $this->conexion->prepare ($sql);
    return $stmt->execute(["id" => $id]);

}



}
?>