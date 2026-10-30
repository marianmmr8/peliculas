<?php

class peliculas{
    private ?int $id;
    private string $titulo;
    private string $director;
    private int $anio;
    private string $genero;
    private string $imagen;
    private bool $visto;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getDirector(): string
    {
        return $this->director;
    }

    public function getAnio(): int
    {
        return $this->anio;
    }

    public function getGenero(): string
    {
        return $this->genero;
    }

    public function getImagen(): string
    {
        return $this->imagen;
    }

    public function getVisto(): bool
    {
        return $this->visto;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    public function setDirector(string $director): void
    {
        $this->director = $director;
    }

    public function setAnio(int $anio): void
    {
        $this->anio = $anio;
    }

    public function setGenero(string $genero): void
    {
        $this->genero = $genero;
    }

    public function setImagen(string $imagen): void
    {
        $this->imagen = $imagen;
    }

    public function setVisto(bool $visto): void
    {
        $this->visto = $visto;
    }
}
?>