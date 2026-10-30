<?php
require_once __DIR__ . "/../clases/directorDao.php";
$directorDAO = new DirectorDao();

$nombre = $_POST["nombre"] ?? "";
$nacimiento = $_POST ["anio"] ?? null;
$biografia = $_POST ["biografia"]?? "";

$directorNuevo = new Director($nombre, $nacimiento, $biografia);

$directorDAO->setDirector($directorNuevo);

header("Location: index.php");
exit;
?>