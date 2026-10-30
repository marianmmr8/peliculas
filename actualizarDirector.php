<?php

require_once("clases/directorDao.php");


$directorDao = new DirectorDAO();
$dire = $directorDao->getById(13);
$dire->setBiografia("pues no son tan buenas");
$directorDao->actualizar($dire);

echo "ya";
?>