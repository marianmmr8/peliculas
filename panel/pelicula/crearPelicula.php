
<?php
require_once __DIR__ . "/../../clases/peliculaDao.php";
$peliculaDAO = new peliculasDao();
$id = $_POST['id']  ?? "";
$titulo = $_POST["titulo"] ?? "";
$director = $_POST["director"] ?? "";
$anio = (int) ($_POST ["anio"] ?? 0);
$genero = $_POST ["genero"]?? "";
$imagen = $_POST["imagen"] ?? "";
$vista = $_POST["vista"] ?? "";
//si existe el id se puede modificar el director 
if($id){
$peliculaModificado = new peliculas($titulo, $director, $anio, $genero, $imagen, $vista, $id);
$peliculaDAO->actualizar($peliculaModificado);

}else{

$peliculaNuevo = new peliculas($titulo, $director, $anio, $genero, $imagen, $vista);
$peliculaDAO->setPelicula($peliculaNuevo);
}


header("Location: ../index.php?vista=directores");
exit;
?>