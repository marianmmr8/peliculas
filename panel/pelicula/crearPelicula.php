<?php
require_once __DIR__ . "/../../clases/peliculasDAO.php";
$peliculaDAO = new peliculasDAO();

/**
 * Genera un nombre seguro para la imagen a partir del título y el ID.
 * Translitera acentos, elimina caracteres no alfanuméricos y usa guiones
 * como separadores entre palabras.
 *
 * @param string $titulo Título de la película.
 * @param int $id Identificador de la película.
 * @param string $extension Extensión validada de la imagen, sin punto.
 * @return string Nombre normalizado con el ID y la extensión.
 * @throws RuntimeException Si no se puede convertir el título a texto ASCII.
 */
function generarNombreImagen(string $titulo, int $id, string $extension): string
{
    $tituloAscii = iconv("UTF-8", "ASCII//TRANSLIT//IGNORE", $titulo);
    if ($tituloAscii === false) {
        throw new RuntimeException("No se pudo generar el nombre de la imagen.");
    }

    $tituloNormalizado = strtolower($tituloAscii);
    $tituloNormalizado = preg_replace("/[^a-z0-9]+/", "-", $tituloNormalizado);
    $tituloNormalizado = trim($tituloNormalizado, "-");

    if ($tituloNormalizado === "") {
        $tituloNormalizado = "pelicula";
    }

    return $tituloNormalizado . "-" . $id . "." . $extension;
}

/**
 * Valida y guarda una imagen subida en la carpeta images del proyecto.
 *
 * Comprueba el estado de la subida, el tamaño máximo, que sea una imagen
 * admitida y que la carpeta de destino permita escribir.
 *
 * @param array|null $archivo Datos de $_FILES o null si no se envió archivo.
 * @param string $titulo Título usado para crear el nombre del archivo.
 * @param int $id ID usado para distinguir la imagen de otras películas.
 * @return string|null Nombre guardado, o null si no se seleccionó una imagen.
 * @throws RuntimeException Si la subida o el guardado no es válido.
 */
function subirImagen(?array $archivo, string $titulo, int $id): ?string
{
    if ($archivo === null || $archivo["error"] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($archivo["error"] !== UPLOAD_ERR_OK) {
        throw new RuntimeException("No se pudo recibir la imagen. Inténtalo de nuevo.");
    }

    $maximoBytes = 5 * 1024 * 1024;
    if ($archivo["size"] > $maximoBytes) {
        throw new RuntimeException("La imagen no puede superar los 5 MB.");
    }

    if (!is_uploaded_file($archivo["tmp_name"])) {
        throw new RuntimeException("El archivo recibido no es una subida válida.");
    }

    $informacionImagen = getimagesize($archivo["tmp_name"]);
    $extensionesPermitidas = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp",
        "image/gif" => "gif"
    ];
    $tipoImagen = $informacionImagen["mime"] ?? "";

    if ($informacionImagen === false || !isset($extensionesPermitidas[$tipoImagen])) {
        throw new RuntimeException("El archivo debe ser una imagen JPG, PNG, WEBP o GIF.");
    }

    $directorioImagenes = __DIR__ . "/../../images";
    if (!is_dir($directorioImagenes) || !is_writable($directorioImagenes)) {
        throw new RuntimeException("La carpeta de imágenes no existe o no permite guardar archivos.");
    }

    $nombreImagen = generarNombreImagen($titulo, $id, $extensionesPermitidas[$tipoImagen]);
    $rutaDestino = $directorioImagenes . DIRECTORY_SEPARATOR . $nombreImagen;

    if (!move_uploaded_file($archivo["tmp_name"], $rutaDestino)) {
        throw new RuntimeException("No se pudo guardar la imagen en el servidor.");
    }

    return $nombreImagen;
}
$id = $_POST['id']  ?? "";
$titulo = $_POST["titulo"] ?? "";
$director = $_POST["director"] ?? "";
$anio = (int) ($_POST ["anio"] ?? 0);
$genero = $_POST ["genero"]?? "";
try {
    $visto = isset($_POST["visto"]);

    if ($id) {
        $idPelicula = (int) $id;
        $peliculaExistente = $peliculaDAO->getById($idPelicula);
        if ($peliculaExistente === null) {
            http_response_code(404);
            exit("No se encontró la película que intentas modificar.");
        }

        $imagenSubida = subirImagen($_FILES["imagen"] ?? null, $titulo, $idPelicula);
        $imagen = $imagenSubida ?? $peliculaExistente->getImagen();
        $peliculaModificada = new peliculas($titulo, $director, $anio, $genero, $imagen, $visto, $idPelicula);
        $peliculaDAO->actualizar($peliculaModificada);
    } else {
        $peliculaNueva = new peliculas($titulo, $director, $anio, $genero, "", $visto);
        $idNuevo = $peliculaDAO->setPelicula($peliculaNueva);

        try {
            $imagenSubida = subirImagen($_FILES["imagen"] ?? null, $titulo, $idNuevo);
            if ($imagenSubida !== null) {
                $peliculaNueva->setId($idNuevo);
                $peliculaNueva->setImagen($imagenSubida);
                if (!$peliculaDAO->actualizar($peliculaNueva)) {
                    throw new RuntimeException("No se pudo asociar la imagen con la película.");
                }
            }
        } catch (RuntimeException $error) {
            $peliculaDAO->eliminar($idNuevo);
            http_response_code(400);
            exit(htmlspecialchars($error->getMessage(), ENT_QUOTES, 'UTF-8'));
        }
    }
} catch (RuntimeException $error) {
    http_response_code(400);
    exit(htmlspecialchars($error->getMessage(), ENT_QUOTES, 'UTF-8'));
}

header("Location: ../index.php?vista=peliculas");
exit;
?>