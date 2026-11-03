<?php
require_once __DIR__ . "/../../clases/peliculasDAO.php";
$peliculaDAO = new peliculasDAO();

function subirImagen(?array $archivo): ?string
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

    $nombreImagen = bin2hex(random_bytes(16)) . "." . $extensionesPermitidas[$tipoImagen];
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
    $imagenSubida = subirImagen($_FILES["imagen"] ?? null);
} catch (RuntimeException $error) {
    http_response_code(400);
    exit(htmlspecialchars($error->getMessage(), ENT_QUOTES, 'UTF-8'));
}
$visto = isset($_POST["visto"]);
//si existe el id se puede modificar la pelicula
if($id){
$peliculaExistente = $peliculaDAO->getById((int) $id);
if ($peliculaExistente === null) {
    http_response_code(404);
    exit("No se encontró la película que intentas modificar.");
}
$imagen = $imagenSubida ?? $peliculaExistente->getImagen();
$peliculaModificado = new peliculas($titulo, $director, $anio, $genero, $imagen, $visto, (int) $id);
$peliculaDAO->actualizar($peliculaModificado);

}else{

$imagen = $imagenSubida ?? "";
$peliculaNuevo = new peliculas($titulo, $director, $anio, $genero, $imagen, $visto);
$peliculaDAO->setPelicula($peliculaNuevo);
}


header("Location: ../index.php?vista=peliculas");
exit;
?>