<?php

class peliculas{
    private ?int $id;
    private string $titulo;
    private string $director;
    private int $anio;
    private string $genero;
    private string $imagen;
    private bool $visto;

    /**
     * Crea una película y guarda sus datos en el objeto.
     *
     * @param string $titulo Título de la película.
     * @param string $director Nombre del director.
     * @param int $anio Año de estreno.
     * @param string $genero Género cinematográfico.
     * @param string $imagen Nombre del archivo de carátula.
     * @param bool $visto Indica si la película ya se ha visto.
     * @param int|null $id Identificador de la película, o null si aún no está guardada.
     */
    public function __construct(
        string $titulo,
        string $director,
        int $anio,
        string $genero,
        string $imagen,
        bool $visto = false,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->director = $director;
        $this->anio = $anio;
        $this->genero = $genero;
        $this->imagen = $imagen;
        $this->visto = $visto;
    }

    /** Devuelve el identificador de la película, si ya está guardada. */
    public function getId(): ?int
    {
        return $this->id;
    }

    /** Devuelve el título de la película. */
    public function getTitulo(): string
    {
        return $this->titulo;
    }

    /** Devuelve el nombre del director de la película. */
    public function getDirector(): string
    {
        return $this->director;
    }

    /** Devuelve el año de estreno de la película. */
    public function getAnio(): int
    {
        return $this->anio;
    }

    /** Devuelve el género cinematográfico de la película. */
    public function getGenero(): string
    {
        return $this->genero;
    }

    /** Devuelve el nombre del archivo de imagen de la película. */
    public function getImagen(): string
    {
        return $this->imagen;
    }

    /** Indica si la película está marcada como vista. */
    public function getVisto(): bool
    {
        return $this->visto;
    }

    /** Asigna o cambia el identificador de la película. */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /** Cambia el título de la película. */
    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    /** Cambia el nombre del director de la película. */
    public function setDirector(string $director): void
    {
        $this->director = $director;
    }

    /** Cambia el año de estreno de la película. */
    public function setAnio(int $anio): void
    {
        $this->anio = $anio;
    }

    /** Cambia el género cinematográfico de la película. */
    public function setGenero(string $genero): void
    {
        $this->genero = $genero;
    }

    /** Cambia el nombre del archivo de imagen de la película. */
    public function setImagen(string $imagen): void
    {
        $this->imagen = $imagen;
    }

    /** Marca la película como vista o no vista. */
    public function setVisto(bool $visto): void
    {
        $this->visto = $visto;
    }
}
?>