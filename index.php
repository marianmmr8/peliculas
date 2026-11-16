<?php
require_once __DIR__ . "/clases/peliculasDAO.php";

$peliculasDAO = new peliculasDAO();
$todasLasPeliculas = $peliculasDAO->getAll();
$busqueda = trim((string) ($_GET["q"] ?? ""));
$generoSeleccionado = trim((string) ($_GET["genero"] ?? ""));
$normalizarTexto = static function (string $texto): string {
    if (function_exists("mb_strtolower")) {
        return mb_strtolower($texto, "UTF-8");
    }

    return strtr(strtolower($texto), [
        "Á" => "á",
        "É" => "é",
        "Í" => "í",
        "Ó" => "ó",
        "Ú" => "ú",
        "Ü" => "ü",
        "Ñ" => "ñ"
    ]);
};
$sinopsisPorTitulo = [
    "mad max: fury road" => "En un desierto sin ley, Max y Furiosa emprenden una huida desesperada para liberar a un grupo de cautivas.",
    "oppenheimer" => "El físico J. Robert Oppenheimer lidera el proyecto que desarrolla la primera bomba atómica y afronta sus consecuencias.",
    "el viaje de chihiro" => "Una niña llega a un mundo mágico y deberá encontrar valor para salvar a sus padres y regresar a casa.",
    "coco" => "Miguel, un joven músico, cruza al mundo de los muertos para descubrir la historia y los secretos de su familia.",
    "interstellar" => "Un piloto viaja más allá de la Tierra para buscar un nuevo hogar y preservar el futuro de la humanidad.",
    "amélie" => "Una joven parisina decide mejorar en secreto la vida de quienes la rodean mientras descubre sus propios deseos.",
    "el padrino" => "Don Vito Corleone protege a su familia y su poder, mientras Michael se adentra en el negocio familiar.",
    "air" => "Un vendedor de Nike apuesta por fichar a una joven promesa del baloncesto y cambiar el rumbo de la compañía.",
    "el laberinto del fauno" => "En la España de posguerra, Ofelia descubre un mundo fantástico que la enfrenta a pruebas misteriosas.",
    "la la land" => "Una aspirante a actriz y un músico persiguen sus sueños en Los Ángeles mientras construyen una relación.",
    "tiburón" => "Un jefe de policía, un oceanógrafo y un cazador se unen para detener al tiburón que amenaza su pueblo.",
    "parásitos" => "Una familia con pocos recursos se infiltra en el hogar de una familia rica, con consecuencias inesperadas.",
    "el diario de noa" => "Dos jóvenes de distintos entornos viven un romance que los une a través del tiempo y las dificultades."
];

$generos = [];
$hayPeliculasSinGenero = false;
foreach ($todasLasPeliculas as $pelicula) {
    $genero = trim($pelicula->getGenero());
    if ($genero !== "") {
        $claveGenero = $normalizarTexto($genero);
        if (!isset($generos[$claveGenero])) {
            $generos[$claveGenero] = $genero;
        }
    } else {
        $hayPeliculasSinGenero = true;
    }
}
if ($hayPeliculasSinGenero) {
    $generos["sin género"] = "Sin género";
}
asort($generos, SORT_NATURAL | SORT_FLAG_CASE);

$destacada = $todasLasPeliculas[0] ?? null;
$listaPeliculas = $todasLasPeliculas;

if ($busqueda !== "") {
    $listaPeliculas = array_values(array_filter($listaPeliculas, static function (peliculas $pelicula) use ($busqueda): bool {
        $campos = [
            $pelicula->getTitulo(),
            $pelicula->getDirector(),
            $pelicula->getAnio(),
            $pelicula->getGenero()
        ];

        foreach ($campos as $campo) {
            $coincide = function_exists("mb_stripos")
                ? mb_stripos((string) $campo, $busqueda, 0, "UTF-8") !== false
                : stripos((string) $campo, $busqueda) !== false;

            if ($coincide) {
                return true;
            }
        }

        return false;
    }));
}

if ($generoSeleccionado !== "") {
    $listaPeliculas = array_values(array_filter(
        $listaPeliculas,
        static function (peliculas $pelicula) use ($generoSeleccionado, $normalizarTexto): bool {
            $genero = trim($pelicula->getGenero());
            $genero = $genero !== "" ? $genero : "Sin género";
            return $normalizarTexto($genero) === $normalizarTexto($generoSeleccionado);
        }
    ));
}

$peliculasPorGenero = [];
$nombresPorGenero = [];
foreach ($listaPeliculas as $pelicula) {
    $genero = trim($pelicula->getGenero());
    $genero = $genero !== "" ? $genero : "Sin género";
    $claveGenero = $normalizarTexto($genero);
    $nombreGenero = $generos[$claveGenero] ?? $genero;
    $peliculasPorGenero[$claveGenero][] = $pelicula;
    $nombresPorGenero[$claveGenero] = $nombreGenero;
}
uksort($peliculasPorGenero, "strnatcasecmp");

$parametrosFiltro = [];
if ($busqueda !== "") {
    $parametrosFiltro["q"] = $busqueda;
}
$urlTodosLosGeneros = "index.php";
if ($parametrosFiltro !== []) {
    $urlTodosLosGeneros .= "?" . http_build_query($parametrosFiltro);
}
$urlTodosLosGeneros .= "#catalogo";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explora películas de tu colección y filtra por género.">
    <title>Películas | Cinefilia</title>
    <link rel="stylesheet" href="css/catalogo.css">
</head>
<body>
    <header class="site-header">
        <a class="brand" href="index.php" aria-label="Inicio, Cinefilia">
            <span class="brand-mark" aria-hidden="true">C</span>
            <span>CINEFILIA</span>
        </a>
        <nav class="site-nav" aria-label="Navegación principal">
            <a class="nav-link" href="#catalogo">Películas</a>
            <a class="nav-link" href="panel/index.php?vista=directores">Directores</a>
            <a class="nav-action" href="panel/">Iniciar sesión</a>
        </nav>
    </header>

    <main>
        <section class="hero" aria-labelledby="hero-title">
            <?php if ($destacada && $destacada->getImagen() !== ""): ?>
                <div class="hero-backdrop" aria-hidden="true">
                    <img src="images/<?= rawurlencode(basename($destacada->getImagen())) ?>" alt="">
                </div>
            <?php endif; ?>
            <div class="hero-content">
                <p class="eyebrow">Tu próxima película favorita</p>
                <?php if ($destacada): ?>
                    <p class="featured-label">Destacada</p>
                    <h1 id="hero-title"><?= htmlspecialchars($destacada->getTitulo(), ENT_QUOTES, "UTF-8") ?></h1>
                    <p class="hero-copy">
                        <?= htmlspecialchars($destacada->getGenero(), ENT_QUOTES, "UTF-8") ?>
                        <span aria-hidden="true">·</span>
                        <?= htmlspecialchars((string) $destacada->getAnio(), ENT_QUOTES, "UTF-8") ?>
                        <span aria-hidden="true">·</span>
                        <?= htmlspecialchars($destacada->getVisto() ? "Vista" : "Pendiente", ENT_QUOTES, "UTF-8") ?>
                    </p>
                    <p class="hero-description">
                        Dirigida por <?= htmlspecialchars($destacada->getDirector(), ENT_QUOTES, "UTF-8") ?>.
                        Descubre esta y otras películas de tu colección.
                    </p>
                <?php else: ?>
                    <h1 id="hero-title">Tu cine, a un clic.</h1>
                    <p class="hero-copy">Explora las películas de tu colección.</p>
                <?php endif; ?>
                <a class="hero-button" href="#catalogo">Explorar películas</a>
            </div>
        </section>

        <section class="collection" id="catalogo" aria-labelledby="collection-title">
            <div class="collection-heading">
                <div>
                    <p class="eyebrow">Explora la colección</p>
                    <h2 id="collection-title">Películas para cada momento</h2>
                </div>
                <form class="search-form" action="index.php#catalogo" method="GET" role="search">
                    <label class="visually-hidden" for="busqueda">Buscar películas</label>
                    <?php if ($generoSeleccionado !== ""): ?>
                        <input type="hidden" name="genero" value="<?= htmlspecialchars($generoSeleccionado, ENT_QUOTES, "UTF-8") ?>">
                    <?php endif; ?>
                    <input
                        id="busqueda"
                        type="search"
                        name="q"
                        placeholder="Buscar película, director o género"
                        value="<?= htmlspecialchars($busqueda, ENT_QUOTES, "UTF-8") ?>"
                    >
                    <button type="submit" aria-label="Buscar">Buscar</button>
                </form>
            </div>

            <nav class="genre-filters" aria-label="Filtrar por género">
                <a class="genre-chip <?= $generoSeleccionado === "" ? "is-active" : "" ?>"
                   href="<?= htmlspecialchars($urlTodosLosGeneros, ENT_QUOTES, "UTF-8") ?>">Todos</a>
                <?php foreach ($generos as $genero): ?>
                    <?php
                    $parametrosGenero = $parametrosFiltro;
                    $parametrosGenero["genero"] = $genero;
                    $urlGenero = "index.php?" . http_build_query($parametrosGenero) . "#catalogo";
                    $generoActivo = $normalizarTexto($genero) === $normalizarTexto($generoSeleccionado);
                    ?>
                    <a class="genre-chip <?= $generoActivo ? "is-active" : "" ?>"
                       href="<?= htmlspecialchars($urlGenero, ENT_QUOTES, "UTF-8") ?>"
                       <?= $generoActivo ? 'aria-current="true"' : "" ?>>
                        <?= htmlspecialchars($genero, ENT_QUOTES, "UTF-8") ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <p class="result-count" aria-live="polite">
                <?= count($listaPeliculas) ?>
                <?= count($listaPeliculas) === 1 ? "película" : "películas" ?>
                <?php if ($busqueda !== ""): ?>
                    para «<?= htmlspecialchars($busqueda, ENT_QUOTES, "UTF-8") ?>»
                <?php endif; ?>
            </p>

            <?php if ($listaPeliculas === []): ?>
                <div class="empty-state">
                    <h3>No encontramos películas</h3>
                    <p>
                        Prueba con otra búsqueda o selecciona un género diferente.
                    </p>
                </div>
            <?php else: ?>
                <?php foreach ($peliculasPorGenero as $claveGenero => $peliculasDelGenero): ?>
                    <?php $genero = $nombresPorGenero[$claveGenero]; ?>
                    <section class="genre-row" aria-labelledby="genero-<?= htmlspecialchars(sha1($claveGenero), ENT_QUOTES, "UTF-8") ?>">
                        <div class="genre-heading">
                            <h3 id="genero-<?= htmlspecialchars(sha1($genero), ENT_QUOTES, "UTF-8") ?>">
                                <?= htmlspecialchars($genero, ENT_QUOTES, "UTF-8") ?>
                            </h3>
                            <span><?= count($peliculasDelGenero) ?> <?= count($peliculasDelGenero) === 1 ? "título" : "títulos" ?></span>
                        </div>
                        <div class="movie-row">
                            <?php foreach ($peliculasDelGenero as $pelicula): ?>
                                <article class="movie-card">
                                    <div class="poster">
                                        <?php if ($pelicula->getImagen() !== ""): ?>
                                            <img
                                                src="images/<?= rawurlencode(basename($pelicula->getImagen())) ?>"
                                                alt="Carátula de <?= htmlspecialchars($pelicula->getTitulo(), ENT_QUOTES, "UTF-8") ?>"
                                                loading="lazy"
                                            >
                                        <?php else: ?>
                                            <div class="poster-placeholder" aria-hidden="true">Sin carátula</div>
                                        <?php endif; ?>
                                        <span class="watch-status <?= $pelicula->getVisto() ? "is-watched" : "" ?>">
                                            <?= $pelicula->getVisto() ? "Vista" : "Pendiente" ?>
                                        </span>
                                    </div>
                                    <?php
                                    $tituloNormalizado = $normalizarTexto($pelicula->getTitulo());
                                    $sinopsis = $sinopsisPorTitulo[$tituloNormalizado]
                                        ?? sprintf(
                                            "Una historia de %s dirigida por %s, parte de tu colección.",
                                            $pelicula->getGenero(),
                                            $pelicula->getDirector()
                                        );
                                    ?>
                                    <div class="movie-info">
                                        <h4 class="movie-title"><?= htmlspecialchars($pelicula->getTitulo(), ENT_QUOTES, "UTF-8") ?></h4>
                                        <p class="movie-meta">
                                            <?= htmlspecialchars((string) $pelicula->getAnio(), ENT_QUOTES, "UTF-8") ?>
                                            <span aria-hidden="true">·</span>
                                            <?= htmlspecialchars($pelicula->getVisto() ? "Vista" : "Pendiente", ENT_QUOTES, "UTF-8") ?>
                                        </p>
                                        <p class="movie-synopsis"><?= htmlspecialchars($sinopsis, ENT_QUOTES, "UTF-8") ?></p>
                                        <button
                                            class="play-button"
                                            type="button"
                                            data-title="<?= htmlspecialchars($pelicula->getTitulo(), ENT_QUOTES, "UTF-8") ?>"
                                        >
                                            <span aria-hidden="true">▶</span>
                                            Reproducir
                                        </button>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </section>
                    <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>

    <footer class="site-footer">
        <a href="panel/index.php?vista=directores">Ver directores</a>
        <p>CINEFILIA · Tu colección de películas</p>
        <a href="panel/">Administrar catálogo</a>
    </footer>

    <dialog class="player-dialog" id="player-dialog" aria-labelledby="player-title">
        <form method="dialog">
            <button class="dialog-close" type="submit" aria-label="Cerrar">×</button>
        </form>
        <p class="eyebrow">Reproductor</p>
        <h2 id="player-title">Reproducción no disponible</h2>
        <p>Esta película todavía no tiene un vídeo asociado en el catálogo.</p>
        <form method="dialog">
            <button class="dialog-confirm" type="submit">Entendido</button>
        </form>
    </dialog>

    <script>
        const playerDialog = document.getElementById("player-dialog");
        const playerTitle = document.getElementById("player-title");

        document.querySelectorAll(".play-button").forEach((button) => {
            button.addEventListener("click", () => {
                playerTitle.textContent = `Reproducir: ${button.dataset.title}`;
                playerDialog.showModal();
            });
        });
    </script>
</body>
</html>
