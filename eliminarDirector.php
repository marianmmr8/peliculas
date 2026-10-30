<?php

require_once("clases/directorDao.php");


$directorDao = new DirectorDAO();
$directorDao->eliminar(13);


echo "eliminado";
?>