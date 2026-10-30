<?php

require_once __DIR__ . "/peliculas.php";
require_once __DIR__ . "/../datos/config.php";

class peliculasDAO
{
    private PDO $conexion;

    public function __construct()
    {
        global $servidor, $nombreBase, $usuario, $password;

        $dsn = "mysql:host=$servidor;dbname=$nombreBase;charset=utf8mb4";
        $this->conexion = new PDO($dsn, $usuario, $password);
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM peliculas";
        $stmt = $this->conexion->query($sql);
        $peliculas = [];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $peliculas[] = new peliculas(
                $fila["titulo"],
                $fila["director"],
                (int) $fila["anio"],
                $fila["genero"],
                $fila["imagen"],
                (bool) $fila["visto"],
                (int) $fila["id"]
            );
        }

        return $peliculas;
    }
}