<?php
require_once __DIR__ . "/../../clases/peliculasDAO.php";
$peliculaDAO = new peliculasDAO();

$id = $_GET["id"]?? null;

$peliculaDAO->eliminar($id);
header("Location: ../index.php?vista=peliculas");
exit;