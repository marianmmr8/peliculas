<?php

require_once("clases/directorDao.php");
$nuevoDirector = new Director("Steven Spielberg", 1949,"tiene peliculas muy buenas ");

$directorDao = new DirectorDAO();
$directorDao->setDirector($nuevoDirector);
echo "ya";
?>