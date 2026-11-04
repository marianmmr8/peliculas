<?php
// esta funcion es para unir las bases de datos requiere, requiere_once, include_once o include , 
// sus diferencias son que requiere da error cuando no encuentra un archivo y para la ejecucion,
//  el include solo da un warning y el termino once hace que solo se importe una vez no se repita

require_once __DIR__ . "/usuario.php";
require_once __DIR__ . "/../datos/config.php";

// creamos una conexion con la base de datos 
class UsuarioDao{

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


public function getAll():array{
    $sql = "SELECT * FROM usuario";

    $stmt = $this->conexion->query($sql);
    $usuarios = [];

    while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
$usuarios[] = new Usuario(
    $fila["nombre"],
    $fila["password"],
     $fila['rol'],
    $fila["id"]

);
    }

return $usuarios;

}

public function getById(int $id): ?Usuario{
    $sql = "SELECT * FROM usuario WHERE id = :id";

    $stmt = $this ->conexion->prepare($sql);
    $stmt->execute(["id"=> $id]);

    $fila = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$fila){
        return null;
    }
    return new Usuario (
    $fila["nombre"],
    $fila["password"],
     $fila['rol'],
    $fila["id"]
    );

}

public function existeNombre(string $nombre, ?int $idExcluir = null): bool
{
    $sql = "SELECT COUNT(*) FROM usuario WHERE nombre = :nombre";
    $parametros = ["nombre" => $nombre];

    if ($idExcluir !== null) {
        $sql .= " AND id <> :id";
        $parametros["id"] = $idExcluir;
    }

    $stmt = $this->conexion->prepare($sql);
    $stmt->execute($parametros);

    return (int) $stmt->fetchColumn() > 0;
}

public function setUsuario(Usuario $usuario): bool{
    $sql = "INSERT INTO usuario (nombre, password, rol) VALUES(:nombre,:password, :rol)";

$passwordHash = password_hash($usuario->getPassword(), PASSWORD_DEFAULT);


    $stmt = $this->conexion->prepare($sql);
    return $stmt->execute([
        "nombre" => $usuario->getNombre(),
        "password" => $passwordHash,
        "rol"=> $usuario-> getRol()
        
    ]);
}

public function actualizar(Usuario $usuario):bool{

$passwordAnterior =$usuario->getPassword();

if($passwordAnterior === ''){
 $sql = "UPDATE usuario
    SET nombre =:nombre,
    rol = :rol
    WHERE id= :id";

      $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        "nombre" => $usuario->getNombre(),
        "id" => $usuario->getId(),
        "rol"=> $usuario->getRol()
    ]);
}else{
    $passwordHash = password_hash($usuario->getPassword(), PASSWORD_DEFAULT);
    $sql = "UPDATE usuario
    SET nombre =:nombre,
    rol = :rol
        password = :password
    WHERE id= :id";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        "nombre" => $usuario->getNombre(),
        "password" => $passwordHash,
         "rol"=> $usuario->getRol(),
        "id" => $usuario->getId()
    ]);

}


   
}


public function eliminar(int $id):bool{
    if($id === 2){
        return false;
    }
    $sql = "DELETE FROM usuario WHERE id = :id";
    $stmt = $this->conexion->prepare ($sql);
    return $stmt->execute(["id" => $id]);

}

public function existeUsuario(string $nombre, string $password){
  $sql = "SELECT * FROM usuario WHERE nombre = :nombre";

  $stmt = $this->conexion->prepare($sql);
  $stmt->execute(["nombre" => $nombre]);

  $fila  = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$fila || !password_verify($password, $fila["password"])) {
    return null;
  }
return new Usuario(
    $fila['nombre'],
    $fila['password'],
    $fila['rol'],
    $fila['id']
  );
}



}
?>