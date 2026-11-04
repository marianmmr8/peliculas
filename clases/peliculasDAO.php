<?php

require_once __DIR__ . "/peliculas.php";
require_once __DIR__ . "/../datos/config.php";

class peliculasDAO
{
    private PDO $conexion;

    /**
     * Abre la conexión PDO con la base de datos configurada en datos/config.php.
     */
    public function __construct()
    {
        global $servidor, $nombreBase, $usuario, $password;

        $dsn = "mysql:host=$servidor;dbname=$nombreBase;charset=utf8mb4";
        $this->conexion = new PDO($dsn, $usuario, $password);
    }

    /**
     * Recupera todas las películas y las convierte en objetos peliculas.
     *
     * @return peliculas[] Lista de películas; queda vacía si no hay registros.
     */
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

    /**
     * Busca una película por su identificador.
     *
     * @param int $id Identificador de la película.
     * @return peliculas|null La película encontrada o null si no existe.
     */
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

    /**
     * Inserta una película en la base de datos y devuelve el ID generado.
     *
     * @param peliculas $pelicula Objeto con los datos que se van a guardar.
     * @return int Identificador asignado por la base de datos.
     */
    public function setPelicula(peliculas $pelicula): int
    {
        $sql = "INSERT INTO peliculas (titulo, director, anio, genero, imagen, visto)
                VALUES (:titulo, :director, :anio, :genero, :imagen, :visto)";
        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([
            "titulo" => $pelicula->getTitulo(),
            "director" => $pelicula->getDirector(),
            "anio" => $pelicula->getAnio(),
            "genero" => $pelicula->getGenero(),
            "imagen" => $pelicula->getImagen(),
            "visto" => $pelicula->getVisto()
        ]);

        return (int) $this->conexion->lastInsertId();
    }

    /**
     * Actualiza los datos de una película existente.
     *
     * @param peliculas $pelicula Objeto con los datos nuevos y el ID existente.
     * @return bool Indica si la consulta de actualización se ejecutó correctamente.
     */
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

    /**
     * Elimina de la base de datos la película indicada.
     *
     * @param int $id Identificador de la película que se eliminará.
     * @return bool Indica si la consulta de eliminación se ejecutó correctamente.
     */
    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM peliculas WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute(["id" => $id]);
    }
}