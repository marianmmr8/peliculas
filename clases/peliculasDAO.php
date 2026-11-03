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
    public function getById(int $id): ?peliculas
    {
        $sql = "SELECT * FROM peliculas WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(["id" => $id]);

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$fila) {
            return null;
        }

        return new peliculas(
            $fila["titulo"],
            $fila["director"],
            (int) $fila["anio"],
            $fila["genero"],
            $fila["imagen"],
            (bool) $fila["visto"],
            (int) $fila["id"]
        );
    }

    public function setPelicula(peliculas $pelicula): bool
    {
        $sql = "INSERT INTO peliculas (titulo, director, anio, genero, imagen, visto)
                VALUES (:titulo, :director, :anio, :genero, :imagen, :visto)";
        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            "titulo" => $pelicula->getTitulo(),
            "director" => $pelicula->getDirector(),
            "anio" => $pelicula->getAnio(),
            "genero" => $pelicula->getGenero(),
            "imagen" => $pelicula->getImagen(),
            "visto" => $pelicula->getVisto()
        ]);
    }

    public function actualizar(peliculas $pelicula): bool
    {
        if ($pelicula->getId() === null) {
            return false;
        }

        $sql = "UPDATE peliculas
                SET titulo = :titulo,
                    director = :director,
                    anio = :anio,
                    genero = :genero,
                    imagen = :imagen,
                    visto = :visto
                WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            "titulo" => $pelicula->getTitulo(),
            "director" => $pelicula->getDirector(),
            "anio" => $pelicula->getAnio(),
            "genero" => $pelicula->getGenero(),
            "imagen" => $pelicula->getImagen(),
            "visto" => $pelicula->getVisto(),
            "id" => $pelicula->getId()
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM peliculas WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute(["id" => $id]);
    }
}