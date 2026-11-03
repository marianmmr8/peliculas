<?php
require_once __DIR__ . "/../../clases/directorDao.php";
$directorDAO = new DirectorDao();

$id = $_GET["id"]?? null;

$directorDAO->eliminar($id);
header("Location: ../index.php?vista=directores");
exit;
?>