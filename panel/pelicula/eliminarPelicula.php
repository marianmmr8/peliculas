<?php
require_once __DIR__ . "/../../clases/peliculasDao.php";
$peliculaDAO = new peliculasDao();

$id = $_GET["id"]?? null;

$peliculaDAO->eliminar($id);
header("Location: ../index.php?vista=peliculas");
exit;