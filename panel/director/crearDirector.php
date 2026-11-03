<?php
require_once __DIR__ . "/../../clases/directorDao.php";
$directorDAO = new DirectorDao();
$id = $_POST['id']  ?? "";
$nombre = $_POST["nombre"] ?? "";
$nacimiento = (int) ($_POST ["anio"] ?? 0);
$biografia = $_POST ["biografia"]?? "";
//si existe el id se puede modificar el director 
if($id){
$directorModificado = new Director($nombre, $nacimiento, $biografia, $id);
$directorDAO->actualizar($directorModificado);

}else{

$directorNuevo = new Director($nombre, $nacimiento, $biografia);
$directorDAO->setDirector($directorNuevo);
}


header("Location: ../index.php?vista=directores");
exit;
?>